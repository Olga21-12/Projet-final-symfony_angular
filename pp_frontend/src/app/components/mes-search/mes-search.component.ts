import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { RechercheService, Recherche } from '../../services/recherche.service';

@Component({
  selector: 'app-mes-search',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './mes-search.component.html',
  styleUrls: ['./mes-search.component.css']
})
export class MesSearchComponent implements OnInit {
  @Input() userId!: number;
  recherches: Recherche[] = [];
  loading = true;

  constructor(private rechercheService: RechercheService) {}

  ngOnInit(): void {
    if (!this.userId) return;

    this.rechercheService.getUserRecherchesById(this.userId).subscribe({
      next: (data) => {
        console.log('📦 Recherches reçues:', data);
        this.recherches = data;
        this.loading = false;
      },
      error: (err) => {
        console.error('Erreur chargement recherches:', err);
        this.loading = false;
      },
    });
  }
}
