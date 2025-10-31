import { ComponentFixture, TestBed } from '@angular/core/testing';
import { of, throwError } from 'rxjs';
import { HttpClientTestingModule } from '@angular/common/http/testing';
import { BienListComponent } from './bien-list.component';
import { BienService } from '../../services/bien.service';
import { FiltreService } from '../../services/filtre.service';
import { Router } from '@angular/router';
import { ActivatedRoute } from '@angular/router';
import { RechercheService } from '../../services/recherche.service';

describe('BienListComponent', () => {
  let component: BienListComponent;
  let fixture: ComponentFixture<BienListComponent>;

  let mockBienService: jasmine.SpyObj<BienService>;
  let mockFiltreService: jasmine.SpyObj<FiltreService>;
  let mockRouter: jasmine.SpyObj<Router>;
  let mockRoute: any;
  let mockRecherche: jasmine.SpyObj<RechercheService>;

  beforeEach(async () => {
    mockBienService = jasmine.createSpyObj('BienService', ['getPaginatedBiens']);
    mockFiltreService = jasmine.createSpyObj('FiltreService', ['search']);
    mockRouter = jasmine.createSpyObj('Router', ['navigate']);
    mockRecherche = jasmine.createSpyObj('RechercheService', ['saveSearch']);
    mockRoute = { queryParams: of({}) };

    await TestBed.configureTestingModule({
      imports: [BienListComponent, HttpClientTestingModule],
      providers: [
        { provide: BienService, useValue: mockBienService },
        { provide: FiltreService, useValue: mockFiltreService },
        { provide: Router, useValue: mockRouter },
        { provide: ActivatedRoute, useValue: mockRoute },
        { provide: RechercheService, useValue: mockRecherche },
      ],
    }).compileComponents();

    fixture = TestBed.createComponent(BienListComponent);
    component = fixture.componentInstance;
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  // === normalizeBien() variants ===
  it('normalizeBien() gère photos sous forme de chaîne', () => {
    const api = { photos: ['photo1.jpg'], user: null };
    const res = (component as any).normalizeBien(api);
    expect(res.photos[0]).toContain('photo1.jpg');
    expect(res.proprietaire).toBe('Anonyme');
  });

  it('normalizeBien() gère photos avec imageName', () => {
    const api = { photos: [{ imageName: 'test.jpg' }], user: { surnom: 'X' } };
    const res = (component as any).normalizeBien(api);
    expect(res.photos[0]).toContain('/uploads/biens/test.jpg');
    expect(res.proprietaire).toBe('X');
  });

  it('normalizeBien() renvoie photo par défaut si vide', () => {
    const api = { photos: [null], user: null };
    const res = (component as any).normalizeBien(api);
    expect(res.photos[0]).toContain('sans_photo.png');
  });

  it('normalizeBien() gère created_ago numérique', () => {
    const api = { photos: [], created_ago: 7 };
    const res = (component as any).normalizeBien(api);
    expect(res.created_ago).toBe(7);
  });

  it('normalizeBien() gère createdAgo en texte', () => {
    const api = { photos: [], createdAgo: 'il y a 2 jours' };
    const res = (component as any).normalizeBien(api);
    expect(res.created_ago).toBe(2);
  });

  // === extractDays() ===
  it('extractDays() extrait un nombre', () => {
    expect((component as any).extractDays('il y a 1 jour')).toBe(1);
  });

  it('extractDays() retourne 0 pour une chaîne vide', () => {
    expect((component as any).extractDays('')).toBe(0);
  });

  // === ngOnInit ===
  it('ngOnInit charge les biens si aucun filtre', () => {
    spyOn(component, 'loadBiens');
    mockRoute.queryParams = of({});
    component.ngOnInit();
    expect(component.loadBiens).toHaveBeenCalled();
  });

  it('ngOnInit applique un filtre si param pays présent', () => {
    spyOn(component, 'onSearch');
    mockRoute.queryParams = of({ pays: 'Belgique' });
    component.ngOnInit();
    expect(component.onSearch).toHaveBeenCalledWith({ pays: 'Belgique' });
  });

  // === loadBiens() ===
  it('loadBiens() charge les données paginées', () => {
    mockBienService.getPaginatedBiens.and.returnValue(of({
      items: [{
        id: 1,
        adresse: 'Rue Test',
        description: '',
        prix: 100,
        surface: 10,
        nombre_de_chambres: 1,
        disponibilite: true,
        luxe: false,
        type: { id: 1, type_de_bien: 'Studio' },
        activite: { id: 1, type_activite: 'Location' },
        emplacement: { pays: 'Belgique', ville: 'Namur' },
        conforts: [],
        photos: [],
        created_at: '',
        updated_at: '',
        created_ago: 0,
      }],
      pagination: { page: 1, totalPages: 2, totalItems: 1 }
    }) as any);
    component.loadBiens(1);
    expect(component.biens.length).toBe(1);
    expect(component.loading).toBeFalse();
  });

  it('loadBiens() gère une erreur', () => {
    mockBienService.getPaginatedBiens.and.returnValue(throwError(() => new Error('err')));
    component.loadBiens(1);
    expect(component.error).toContain('Erreur de chargement');
  });

  // === changePage() ===
  it('changePage appelle loadBiens si valide', () => {
    spyOn(component, 'loadBiens');
    component.totalPages = 3;
    component.changePage(2);
    expect(component.loadBiens).toHaveBeenCalledWith(2);
  });

  it('changePage ne fait rien si invalide', () => {
    spyOn(component, 'loadBiens');
    component.totalPages = 1;
    component.changePage(5);
    expect(component.loadBiens).not.toHaveBeenCalled();
  });

  // === voirBien() ===
  it('voirBien redirige vers login si non connecté', () => {
    spyOn(window, 'alert');
    component.user = null;
    component.voirBien(1);
    expect(mockRouter.navigate).toHaveBeenCalledWith(['/login']);
  });

  it('voirBien navigue vers détail si connecté', () => {
    component.user = { id: 1 };
    component.voirBien(2);
    expect(mockRouter.navigate).toHaveBeenCalledWith(['/biens', 2]);
  });

  // === onSearch() ===
  it('onSearch() met à jour la liste sans user', () => {
    mockFiltreService.search.and.returnValue(of([{ id: 1 }] as any));
    localStorage.removeItem('user');
    component.onSearch({ pays: 'Belgique' });
    expect(component.biens.length).toBe(1);
  });

  it('onSearch() met à jour et sauvegarde la recherche', () => {
    mockFiltreService.search.and.returnValue(of([{
      id: 1,
      adresse: 'Rue du Moulin',
      description: 'Charmant bien à louer',
      prix: 1200,
      surface: 70,
      nombre_de_chambres: 3,
      disponibilite: true,
      luxe: false,
      type: { id: 1, type_de_bien: 'Maison' },
      activite: { id: 2, type_activite: 'Location' },
      emplacement: { pays: 'Belgique', ville: 'Bruxelles' },
      conforts: [],
      photos: [],
      created_at: '',
      updated_at: '',
      created_ago: 0,
    }] as any));
    mockRecherche.saveSearch.and.returnValue(of({}));
    localStorage.setItem('user', JSON.stringify({ id: 42 }));
    component.onSearch({ pays: 'Belgique' });
    expect(mockRecherche.saveSearch).toHaveBeenCalled();
  });

  it('onSearch() gère une erreur', () => {
    mockFiltreService.search.and.returnValue(throwError(() => new Error('err')));
    component.onSearch({});
    expect(component.error).toContain('Erreur de filtrage');
  });

  // === toggleView() ===
  it('toggleView() alterne correctement', () => {
    component.viewMode = 'grid';
    component.toggleView('list');
    expect(component.viewMode).toBe('list');
    component.toggleView('grid');
    expect(component.viewMode).toBe('grid');
  });
});
