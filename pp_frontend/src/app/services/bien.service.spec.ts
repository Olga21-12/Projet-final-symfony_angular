import { TestBed } from '@angular/core/testing';
import { HttpClientTestingModule, HttpTestingController } from '@angular/common/http/testing';
import { BienService } from './bien.service';

describe('BienService', () => {
  let service: BienService;
  let httpMock: HttpTestingController;
  const apiUrl = 'https://127.0.0.1:8000/api/biens';

  interface Bien {
    id: number;
    adresse: string;
    prix: number;
  }

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule],
      providers: [BienService],
    });
    service = TestBed.inject(BienService);
    httpMock = TestBed.inject(HttpTestingController);
  });

  afterEach(() => {
    httpMock.verify();
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });

  it('doit retourner la liste de tous les biens', () => {
    const mockBiens: Bien[] = [{ id: 1, adresse: 'Rue des Lilas', prix: 1000 }];

    service.getAllBiens().subscribe((biens) => {
      expect(biens.length).toBe(1);
      expect(biens[0].adresse).toBe('Rue des Lilas');
    });

    const req = httpMock.expectOne(apiUrl);
    expect(req.request.method).toBe('GET');
    req.flush(mockBiens);
  });

  it('doit retourner le total des biens', () => {
    const mockResponse = { total: 5 };

    service.getTotalBiens().subscribe((total) => {
      expect(total).toBe(5);
    });

    const req = httpMock.expectOne(`${apiUrl}/count`);
    expect(req.request.method).toBe('GET');
    req.flush(mockResponse);
  });

  it('doit récupérer un bien par son id', () => {
    const mockBien: Bien = { id: 42, adresse: 'Avenue Royale', prix: 2500 };

    service.getBienById(42).subscribe((bien) => {
      expect(bien.id).toBe(42);
      expect(bien.adresse).toBe('Avenue Royale');
    });

    const req = httpMock.expectOne(`${apiUrl}/42`);
    expect(req.request.method).toBe('GET');
    req.flush(mockBien);
  });

  it('doit supprimer un bien par son id', () => {
    service.deleteBien(10).subscribe((response) => {
      expect(response).toBeTruthy();
    });

    const req = httpMock.expectOne(`${apiUrl}/10`);
    expect(req.request.method).toBe('DELETE');
    req.flush({ message: 'Bien supprimé' });
  });

  it('doit créer un nouveau bien', () => {
    const mockData = { adresse: 'Rue des Roses', prix: 1200 };
    const mockPhotos: File[] = [];
    const mockResponse = { message: 'Bien créé' };

    service.createBien(mockData, mockPhotos).subscribe((res) => {
      expect(res.message).toBe('Bien créé');
    });

    const req = httpMock.expectOne(apiUrl);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

  it('doit mettre à jour un bien', () => {
    const mockData = { adresse: 'Rue du Château', prix: 3000 };
    const mockPhotos: File[] = [];
    const mockResponse = { message: 'Bien mis à jour' };

    service.updateBien(7, mockData, mockPhotos).subscribe((res) => {
      expect(res.message).toBe('Bien mis à jour');
    });

    const req = httpMock.expectOne(`${apiUrl}/7?_method=PUT`);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

  it('doit retourner les biens d’un utilisateur', () => {
    const mockList = [{ id: 1, adresse: 'Rue Verte', prix: 900 }];
    service.getBiensByUserId(5).subscribe((res) => {
      expect(res.length).toBe(1);
      expect(res[0].adresse).toBe('Rue Verte');
    });

    const req = httpMock.expectOne(`${apiUrl}/user/5`);
    expect(req.request.method).toBe('GET');
    req.flush(mockList);
  });

  it('doit retourner des biens paginés', () => {
    const mockResponse = { items: [{ id: 1 }], pagination: { page: 1 } };

    service.getPaginatedBiens(1, 10).subscribe((res) => {
      expect(res.items.length).toBe(1);
      expect(res.pagination.page).toBe(1);
    });

    const req = httpMock.expectOne(`${apiUrl}?page=1&limit=10`);
    expect(req.request.method).toBe('GET');
    req.flush(mockResponse);
  });

  it('doit filtrer les biens', () => {
    const filters = { ville: 'Bruxelles', luxe: 1 };
    const mockResponse = [{ id: 3, adresse: 'Rue de la Reine' }];

    service.getFilteredBiens(filters).subscribe((res) => {
      expect(res.length).toBe(1);
      expect(res[0].adresse).toBe('Rue de la Reine');
    });

    const req = httpMock.expectOne(`${apiUrl}/filtre?ville=Bruxelles&luxe=1`);
    expect(req.request.method).toBe('GET');
    req.flush(mockResponse);
  });

  it('doit envoyer une demande de location courte durée', () => {
    const mockResponse = { message: 'Location courte durée effectuée' };

    service.shortRent(1, 5, 2).subscribe((res) => {
      expect(res.message).toBe('Location courte durée effectuée');
    });

    const req = httpMock.expectOne(`${apiUrl}/1/short-rent`);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

  it('doit envoyer une demande de location longue durée', () => {
    const mockResponse = { message: 'Location longue durée effectuée' };

    service.longRent(1, 2).subscribe((res) => {
      expect(res.message).toBe('Location longue durée effectuée');
    });

    const req = httpMock.expectOne(`${apiUrl}/1/long-rent`);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

  it('doit envoyer une demande d’achat', () => {
    const mockResponse = { message: 'Achat effectué' };

    service.buy(1, 2).subscribe((res) => {
      expect(res.message).toBe('Achat effectué');
    });

    const req = httpMock.expectOne(`${apiUrl}/1/buy`);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

   it('doit gérer les champs undefined et les tableaux dans createBien', () => {
    const mockData: any = {
      adresse: 'Rue du Soleil',
      conforts: [1, 2, 3],
      description: undefined, 
    };
    const mockPhotos: File[] = [];
    const mockResponse = { message: 'Bien créé avec conforts' };

    service.createBien(mockData, mockPhotos).subscribe((res) => {
      expect(res.message).toBe('Bien créé avec conforts');
    });

    const req = httpMock.expectOne(apiUrl);
    expect(req.request.method).toBe('POST');
    req.flush(mockResponse);
  });

});

