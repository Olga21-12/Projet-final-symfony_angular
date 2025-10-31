import { ComponentFixture, TestBed } from '@angular/core/testing';
import { of, throwError } from 'rxjs';
import { BienFiltreComponent } from './bien-filtre.component';
import { FiltreOptionsService } from '../../services/filtre-options.service';

describe('BienFiltreComponent', () => {
  let component: BienFiltreComponent;
  let fixture: ComponentFixture<BienFiltreComponent>;
  let mockService: jasmine.SpyObj<FiltreOptionsService>;

  beforeEach(async () => {
    
    const serviceSpy = jasmine.createSpyObj('FiltreOptionsService', ['getOptions']);

    await TestBed.configureTestingModule({
      imports: [BienFiltreComponent],
      providers: [{ provide: FiltreOptionsService, useValue: serviceSpy }],
    }).compileComponents();

    fixture = TestBed.createComponent(BienFiltreComponent);
    component = fixture.componentInstance;
    mockService = TestBed.inject(FiltreOptionsService) as jasmine.SpyObj<FiltreOptionsService>;
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('ngOnInit() charge les listes triées', () => {
    const mockResponse = {
      pays: ['Belgique', 'France'],
      villes: ['Namur', 'Bruxelles'],
      types: ['Appartement', 'Maison'],
      activites: ['Location', 'Vente'],
      conforts: ['Wifi', 'Piscine']
    };

    mockService.getOptions.and.returnValue(of(mockResponse));

    component.ngOnInit();

    expect(mockService.getOptions).toHaveBeenCalled();
    expect(component.paysList).toEqual(['Belgique', 'France']);
    expect(component.villesList).toContain('Namur');
    expect(component.typesList.length).toBe(2);
    expect(component.activitesList).toEqual(['Location', 'Vente']);
    expect(component.confortsList).toContain('Piscine');
  });

  it('ngOnInit() gère les erreurs correctement', () => {
    
    const consoleSpy = spyOn(console, 'error');
    mockService.getOptions.and.returnValue(throwError(() => new Error('Erreur réseau')));

    component.ngOnInit();

    expect(mockService.getOptions).toHaveBeenCalled();
    expect(consoleSpy).toHaveBeenCalledWith('Erreur chargement des options', jasmine.any(Error));
  });

  it('toggleSelection() ajoute une valeur si elle est absente', () => {
    const array = ['A'];
    component.toggleSelection(array, 'B');
    expect(array).toContain('B');
  });

  it('toggleSelection() supprime une valeur si elle est présente', () => {
    const array = ['A', 'B'];
    component.toggleSelection(array, 'A');
    expect(array).not.toContain('A');
  });

  it('onSubmit() émet correctement les filtres', () => {
    const emitSpy = spyOn(component.search, 'emit');
    component.filters.q = 'test';
    component.onSubmit();
    expect(emitSpy).toHaveBeenCalledWith(component.filters);
  });

  it('toggleSection() ouvre une section fermée', () => {
    component.openSection = null;
    component.toggleSection('general');
    expect(component.openSection).not.toBeNull(); 
  });


  it('toggleSection() referme une section déjà ouverte', () => {
    component.openSection = 'general';
    component.toggleSection('general');
    expect(component.openSection).toBeNull();
  });
});
