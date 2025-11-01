import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { BienService, Bien } from '../../services/bien.service';
import { TruncatePipe } from '../../pipes/truncate.pipe';
import { FiltreService } from '../../services/filtre.service';
import { BienFiltreComponent } from '../../components/bien-filtre/bien-filtre.component';
import { PaginatorComponent } from '../../components/paginator/paginator.component';
import { ActivatedRoute } from '@angular/router';
import { RechercheService } from '../../services/recherche.service';


@Component({
  selector: 'app-bien-list',
  standalone: true,
  imports: [CommonModule, RouterModule, TruncatePipe, BienFiltreComponent, PaginatorComponent],
  templateUrl: './bien-list.component.html',
  styleUrls: ['./bien-list.component.css']
})
export class BienListComponent implements OnInit {
  biens: Bien[] = [];
  loading = true;
  error = '';
  totalBiens = 0;
  user: any = null;
  currentPage = 1;
  totalPages = 1;
  limit = 6;

  constructor(
    private bienService: BienService,
    private router: Router,
    private filtreService: FiltreService,
    private route: ActivatedRoute,
    private rechercheService: RechercheService
  ) {}

  // Convertit les données de l'API dans un format que le modèle peut comprendre
  private normalizeBien(api: any): Bien {
    // Photo - prend en charge les deux formats : chaînes et objets avec imageName
    const photoPaths = (api.photos || []).map((p: any) => {
      if (typeof p === 'string') {
        return p; // уже готовый путь
      }
      if (p && p.imageName) {
        return `/uploads/biens/${p.imageName}`; // objet avec nom de fichier
      }
      return '/uploads/biens/sans_photo.png'; // option de sauvegarde
    });

    // proprietaire
    const proprietaire = api.user?.surnom ?? api.proprietaire ?? 'Anonyme';

    // type et activite
    const type = api.type?.type_de_bien ?? api.type ?? 'Type inconnu';
    const activite = api.typeActivite?.type_activite ?? api.activite ?? '';

    // nombre de chambres
    const chambres = api.nombre_de_chambres ?? api.nombreDeChambres ?? 0;

    // created Ago
    const createdAgoText =
      typeof api.createdAgo === 'string'
        ? api.createdAgo
        : (typeof api.created_ago === 'number'
            ? `il y a ${api.created_ago} jour${api.created_ago > 1 ? 's' : ''}`
            : '');

    return {
      ...api,
      type,
      activite,
      proprietaire,
      photos: photoPaths.length ? photoPaths : ['/uploads/biens/sans_photo.png'],
      created_ago:
        typeof api.created_ago === 'number'
          ? api.created_ago
          : this.extractDays(createdAgoText),
      createdAgoText,
      nombre_de_chambres: chambres,
      emplacement: api.emplacement ?? { pays: '', ville: '' },
    } as Bien;
  }

  private extractDays(txt: string): number {
    const m = (txt || '').match(/(\d+)/);
    return m ? Number(m[1]) : 0;
  }

  ngOnInit(): void {
    // Vérifiez s'il y a un utilisateur connecté
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      this.user = JSON.parse(storedUser);
    }

    // Vérifiez query - ?pays=
    this.route.queryParams.subscribe(params => {
      const pays = params['pays'];

      if (pays) {
        // filtre de pays
        this.onSearch({ pays });
      } else {
        //  Biens + pagination
        this.loadBiens();
      }
    });
  }

  // Pagination
  loadBiens(page: number = 1): void {
    this.loading = true;

    this.bienService.getPaginatedBiens(page, this.limit).subscribe({
      next: (res) => {
        this.biens = (res.items || []).map((b: any) => this.normalizeBien(b));
        this.currentPage = res.pagination.page;
        this.totalPages = res.pagination.totalPages;
        this.totalBiens = res.pagination.totalItems;
        this.loading = false;
      },
      error: () => {
        this.error = 'Erreur de chargement des biens';
        this.loading = false;
      }
    });
  }

  changePage(page: number): void {
    if (page >= 1 && page <= this.totalPages) {
      this.loadBiens(page);
    }
  }

  // "Voir plus"
  voirBien(bienId: number): void {
    if (!this.user) {
      alert('Pour voir le détail, veuillez vous connecter ou vous inscrire.');
      this.router.navigate(['/login']);
      return;
    }
    this.router.navigate(['/biens', bienId]);
  }

  // filtre
  onSearch(filters: any) {
    this.loading = true;

    this.filtreService.search(filters).subscribe({
      next: (data) => {
        this.biens = (data || []).map((b: any) => this.normalizeBien(b));
        this.totalBiens = this.biens.length;
        this.loading = false;

        // nous enregistrons la recherche UNIQUEMENT si l'utilisateur est autorisé
        const storedUser = localStorage.getItem('user');
        if (storedUser) {
          const user = JSON.parse(storedUser);

          const payload = {
          user_id: user.id,
          pays: filters.pays,
          ville: filters.ville,
          typeBien: filters.typeBien
        };

//          this.rechercheService.saveSearch(payload).subscribe({
//            next: () => console.log('🔹 Recherche sauvegardée'),
//            error: (err) => console.warn('Erreur sauvegarde recherche:', err)
//         });
       }
      },
      error: () => {
        this.error = 'Erreur de filtrage';
        this.loading = false;
      },
    });
  }

    // === Nouveau code pour changer l'affichage ===
  viewMode: 'grid' | 'list' = 'grid'; 

  toggleView(mode: 'grid' | 'list') {
    this.viewMode = mode;
  }
}