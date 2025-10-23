import { EmplacementService } from './../../services/emplacement.service';
import { Component, Input, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { BienService, Bien } from '../../services/bien.service';
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

  @Input() bien: Bien = {
    id: 0,
    adresse: '',
    description: '',
    prix: 0,
    surface: 0,
    nombre_de_chambres: 0,
    disponibilite: true,
    luxe: false,
    type: '',
    activite: '',
    emplacement: { pays: '', ville: '' },
    conforts: [],
    photos: [],
    created_at: '',
    updated_at: '',
    created_ago: 0
  };

  @Input() isEditMode = false;

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

  constructor(
    private bienService: BienService,
    private router: Router,
    private emplacementService: EmplacementService,
    private typeService: TypeService,
    private activiteService: ActiviteService,
    private confortService: ConfortService
  ) {}

  ngOnInit(): void {
    // если редактирование — подставляем данные
    if (this.isEditMode && this.bien.emplacement) {
      this.selectedPays = this.bien.emplacement.pays || '';
      this.selectedVille = this.bien.emplacement.ville || '';
    }

    this.loadPays();
    this.loadTypes();
    this.loadActivites();
    this.loadConforts();

    if (this.selectedPays) {
      this.loadVilles(this.selectedPays);
    }
  }

  // ------------------ PAYS & VILLES ------------------
  loadPays(): void {
    this.emplacementService.getPays().subscribe({
      next: (res) => (this.paysList = res),
      error: () => (this.error = 'Erreur lors du chargement des pays.')
    });
  }

  loadVilles(pays: string): void {
    this.emplacementService.getVilles(pays).subscribe({
      next: (res) => (this.villes = res),
      error: () => (this.error = 'Erreur lors du chargement des villes.')
    });
  }

  onPaysChange(event: any): void {
    const pays = event.target.value;
    this.selectedPays = pays;
    this.selectedVille = '';
    this.villes = [];

    if (pays) {
      this.loadVilles(pays);
    }
  }

  // ------------------ TYPES ------------------
  loadTypes(): void {
    this.typeService.getTypes().subscribe({
      next: (res) => (this.types = res),
      error: () => (this.error = 'Erreur lors du chargement des types.')
    });
  }

  // ------------------ ACTIVITÉS ------------------
  loadActivites(): void {
    this.activiteService.getActivites().subscribe({
      next: (res) => (this.activites = res),
      error: () => (this.error = 'Erreur lors du chargement des activités.')
    });
  }

  // ------------------ CONFORTS ------------------
  onConfortChange(event: any, id: number): void {
    if (event.target.checked) {
      this.bien.conforts.push(id);
    } else {
      this.bien.conforts = this.bien.conforts.filter((c) => c !== id);
    }
  }
  
  loadConforts(): void {
    this.confortService.getConforts().subscribe({
      next: (res) => (this.conforts = res),
      error: () => (this.error = 'Erreur lors du chargement des conforts.')
    });
  }

  // ------------------ PHOTOS ------------------
  onPhotosSelected(event: any): void {
    const files = Array.from(event.target.files) as File[];
    this.photos = files.slice(0, 4);
  }

  // ------------------ SOUMISSION FORMULAIRE ------------------
  onSubmit(): void {
    this.error = '';
    this.message = '';

    if (!this.bien.adresse || !this.bien.prix || !this.selectedPays || !this.selectedVille) {
      this.error = 'Veuillez remplir tous les champs obligatoires.';
      return;
    }

    const payload = {
      ...this.bien,
      pays: this.selectedPays,
      ville: this.selectedVille,
    };

    if (this.isEditMode) {
      this.updateBien(payload);
    } else {
      this.createBien(payload);
    }
  }

  // ------------------ CRÉATION ------------------
  private createBien(payload: any): void {
    this.bienService.createBien(payload, this.photos).subscribe({
      next: (res) => {
        this.message = res.message || 'Bien ajouté avec succès ✅';
        setTimeout(() => this.router.navigate(['/biens']), 1500);
      },
      error: (err) => {
        console.error(err);
        this.error = err.error?.error || 'Erreur lors de l’ajout du bien.';
      }
    });
  }

  // ------------------ MISE À JOUR ------------------
  private updateBien(payload: any): void {
    this.bienService.updateBien(this.bien.id, payload, this.photos).subscribe({
      next: (res) => {
        this.message = res.message || 'Bien mis à jour avec succès ✅';
        setTimeout(() => this.router.navigate(['/biens']), 1500);
      },
      error: (err) => {
        console.error(err);
        this.error = err.error?.error || 'Erreur lors de la mise à jour du bien.';
      }
    });
  }
}

