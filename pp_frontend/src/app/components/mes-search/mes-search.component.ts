import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { RechercheService } from '../../services/recherche.service';

export interface Recherche {
  type: 'location' | 'achat';
  bien_id: number;
  adresse: string;
  ville?: string;
  pays?: string;
  type_bien?: string;
  prix: number;
  date_debut?: string;
  date_fin?: string;
  date_achat?: string;
  photo?: string;
}

@Component({
  selector: 'app-mes-search',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './mes-search.component.html',
  styleUrls: ['./mes-search.component.css']
})
export class MesSearchComponent implements OnInit {
  @Input() userId!: number;
  recherche: Recherche[] = [];
  loading = true;

  constructor(private rechercheService: RechercheService) {}

  ngOnInit(): void {
    if (!this.userId) return;

    this.rechercheService.getByUser(this.userId).subscribe({
      next: (data: Recherche[]) => {
        // tri par date la plus récente
        this.recherche = data.sort((a, b) => {
          const dateA =
            new Date(a.date_achat || a.date_debut || '').getTime() || 0;
          const dateB =
            new Date(b.date_achat || b.date_debut || '').getTime() || 0;
          return dateB - dateA;
        });

        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur chargement transactions:', err);
        this.loading = false;
      }
    });
  }
}
