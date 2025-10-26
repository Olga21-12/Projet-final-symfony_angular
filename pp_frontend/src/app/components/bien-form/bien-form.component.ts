import { EmplacementService } from './../../services/emplacement.service';
import { Component, Input, OnInit, OnChanges, SimpleChanges, Output, EventEmitter } from '@angular/core';
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
export class BienFormComponent implements OnInit, OnChanges {

  currentUserId: number | null = null;

  @Output() formSubmit = new EventEmitter<{ payload: any; photos: File[] }>();

  @Input() bien: Bien = {
    id: 0,
    adresse: '',
    description: '',
    prix: 0,
    surface: 0,
    nombre_de_chambres: 0,
    disponibilite: true,
    luxe: false,
    type: { id: 0, type_de_bien: '' },
    activite: { id: 0, type_activite: '' },
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

  selectedTypeId: number | null = null;
  selectedActiviteId: number | null = null;

  constructor(
    private bienService: BienService,
    private router: Router,
    private emplacementService: EmplacementService,
    private typeService: TypeService,
    private activiteService: ActiviteService,
    private confortService: ConfortService
  ) {}

  // -----------------------------------
  // Initialisation de l'utilisateur et des répertoires
  // -----------------------------------
  ngOnInit(): void {
    const storedUser = localStorage.getItem('user');
    this.currentUserId = storedUser ? JSON.parse(storedUser).id : null;

    this.loadPays();
    this.loadTypes();
    this.loadActivites();
    this.loadConforts();
  }

  // -----------------------------------
  // Réaction aux modifications des données d'entrée (lors de l'édition)
  // -----------------------------------
  ngOnChanges(changes: SimpleChanges): void {
    if (changes['bien'] && this.bien) {
      console.log('📦 Données du bien reçues:', this.bien);
      // Chargement des valeurs sélectionnées uniquement après l'arrivée du bien
      this.selectedTypeId =
        typeof this.bien.type === 'object' ? this.bien.type.id : (this.bien.type as number);

      this.selectedActiviteId =
        typeof this.bien.activite === 'object' ? this.bien.activite.id : (this.bien.activite as number);

      if (this.bien.emplacement) {
        this.selectedPays = this.bien.emplacement.pays || '';
        this.selectedVille = this.bien.emplacement.ville || '';
        if (this.selectedPays) this.loadVilles(this.selectedPays);
      }

      if (this.bien.conforts && this.bien.conforts.length > 0) {
      this.bien.conforts = this.bien.conforts.map((c: any) =>
        typeof c === 'object' ? c.id : c
      );
    }
  }
}

  // -----------------------------------
  // Chargement des listes (pays, villes, types, activités, conforts)
  // -----------------------------------
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

    if (pays) this.loadVilles(pays);
  }

  loadTypes(): void {
  this.typeService.getTypes().subscribe({
    next: (res) => {
      this.types = res;
      console.log('📘 Types reçus:', res);

      // S'il existe déjà un type sélectionné, nous le mettrons à jour
      if (this.bien.type && typeof this.bien.type === 'object') {
        this.selectedTypeId = this.bien.type.id;
        console.log('✅ Type synchronisé:', this.selectedTypeId);
      }
    },
    error: () => (this.error = 'Erreur lors du chargement des types.')
  });
}

loadActivites(): void {
  this.activiteService.getActivites().subscribe({
    next: (res) => {
      this.activites = res;
      console.log('📗 Activités reçues:', res);

      // S'il existe déjà une activité sélectionnée, mettez-la à jour
      if (this.bien.activite && typeof this.bien.activite === 'object') {
        this.selectedActiviteId = this.bien.activite.id;
        console.log('✅ Activité synchronisée:', this.selectedActiviteId);
      }
    },
    error: () => (this.error = 'Erreur lors du chargement des activités.')
  });
}

  loadConforts(): void {
    this.confortService.getConforts().subscribe({
      next: (res) => (this.conforts = res),
      error: () => (this.error = 'Erreur lors du chargement des conforts.')
    });
  }

  // -----------------------------------
  //  Gestion des conforts et photos
  // -----------------------------------
  onConfortChange(event: any, id: number): void {
    if (event.target.checked) {
      this.bien.conforts.push(id);
    } else {
      this.bien.conforts = this.bien.conforts.filter((c) => c !== id);
    }
  }

  onPhotosSelected(event: any): void {
    const files = Array.from(event.target.files) as File[];
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    const maxPerFileBytes = 8 * 1024 * 1024;

    this.photos = files
      .filter(f => allowed.includes(f.type) && f.size <= maxPerFileBytes)
      .slice(0, 4);
  }

  // -----------------------------------
  //  Soumission du formulaire
  // -----------------------------------
  onSubmit(): void {
    this.error = '';
    this.message = '';

    if (!this.bien.adresse || !this.bien.prix || !this.selectedPays || !this.selectedVille) {
      this.error = 'Veuillez remplir tous les champs obligatoires.';
      return;
    }

    // Envoie la structure correcte pour le backend Symfony
    const payload = {
      ...this.bien,
      type: this.selectedTypeId,
      activite: this.selectedActiviteId,
      pays: this.selectedPays,
      ville: this.selectedVille,
      user_id: this.currentUserId
    };

    console.log('🚀 Données envoyées au backend:', payload);

    this.formSubmit.emit({ payload, photos: this.photos });
  }

  private updateBien(payload: any): void {
    this.bienService.updateBien(this.bien.id, payload, this.photos).subscribe({
      next: (res) => {
        this.message = res.message || 'Bien mis à jour avec succès ✅';
        setTimeout(() => this.router.navigate(['/biens']), 1500);
      },
      error: (err) => {
        console.error('ERREUR SERVEUR:', err);
        this.error = err.error?.error || 'Erreur lors de la mise à jour du bien.';
      }
    });
  }
}
