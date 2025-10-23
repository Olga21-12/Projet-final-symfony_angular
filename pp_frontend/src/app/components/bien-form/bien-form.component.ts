import { EmplacementService } from './../../services/emplacement.service';
import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BienService } from '../../services/bien.service';
import { Router } from '@angular/router';
import { TypeService } from '../../services/type.service';
import { ActiviteService } from '../../services/activite.service';
import { ConfortService } from '../../services/confort.service';

@Component({
  selector: 'app-bien-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './bien-form.component.html'
})
export class BienFormComponent implements OnInit {

  @Input() isEditMode = false;
  bien: any = {};
  photos: File[] = [];

  message = '';
  error = '';

  types: any[] = [];
  activites: any[] = [];
  conforts: any[] = [];
  paysList: string[] = [];
  villes: any[] = [];

  selectedPays = '';
  selectedVille = '';

  constructor(private bienService: BienService, 
              private router: Router, 
              private emplacementService: EmplacementService,
              private typeService: TypeService,
              private activiteService: ActiviteService,
              private confortService: ConfortService
            ) {}

  ngOnInit(): void {
    this.loadPays();
    this.loadTypes();
    this.loadActivites();
    this.loadConforts();
  }

  // ------------------ TÉLÉCHARGEMENTS D'ANNUAIRES ------------------
  loadPays(): void {
    this.emplacementService.getPays().subscribe({
      next: (res) => (this.paysList = res),
      error: () => (this.error = 'Erreur lors du chargement des pays.')
    });
  }

  loadTypes(): void {
    this.typeService.getTypes().subscribe({
      next: (res) => (this.types = res),
      error: () => (this.error = 'Erreur lors du chargement des types.')
    });
  }

  loadActivites(): void {
    this.activiteService.getActivites().subscribe({
      next: (res) => (this.activites = res),
      error: () => (this.error = 'Erreur lors du chargement des activités.')
    });
  }

  loadConforts(): void {
    this.confortService.getConforts().subscribe({
      next: (res) => (this.conforts = res),
      error: () => (this.error = 'Erreur lors du chargement des conforts.')
    });
  }

  // ------------------ villes ------------------
  onPaysChange(event: any): void {
    const pays = event.target.value;
    this.selectedPays = pays;
    this.villes = [];
    this.selectedVille = '';

    if (pays) {
      this.emplacementService.getVilles(pays).subscribe({
        next: (res) => (this.villes = res),
        error: () => (this.error = 'Erreur lors du chargement des villes.')
      });
    }
  }

  // ------------------ photos ------------------
  onPhotosSelected(event: any): void {
    const files = Array.from(event.target.files) as File[];
    this.photos = files.slice(0, 4);
  }

  // ------------------ envoe ------------------
  onSubmit(): void {
    if (!this.bien.adresse || !this.bien.prix || !this.selectedPays || !this.selectedVille) {
      this.error = 'Veuillez remplir tous les champs obligatoires.';
      return;
    }

    const payload = {
      ...this.bien,
      pays: this.selectedPays,
      ville: this.selectedVille,
    };

    this.bienService.createBien(payload, this.photos).subscribe({
      next: (res) => {
        this.message = res.message || 'Bien ajouté avec succès ✅';
        this.error = '';
        setTimeout(() => this.router.navigate(['/biens']), 1500);
      },
      error: (err) => {
        console.error(err);
        this.error = err.error?.error || 'Erreur lors de l’envoi du formulaire.';
      }
    });
  }
}
