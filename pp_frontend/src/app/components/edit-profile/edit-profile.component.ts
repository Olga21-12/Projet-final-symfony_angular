import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { UserService } from '../../services/user.service';
import { Router } from '@angular/router';
import { User } from '../../models/user';
import { Emplacement } from '../../models/emplacement';
import { EmplacementService } from '../../services/emplacement.service';

@Component({
  selector: 'app-edit-profile',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './edit-profile.component.html',
  styleUrls: ['./edit-profile.component.css']
})
export class EditProfileComponent implements OnInit{

user!: User;
  paysList: string[] = [];
  villes: Emplacement[] = [];
  selectedPays = '';
  selectedVille = '';

  message = '';
  error = '';
  selectedPhoto?: File;
  previewUrl: string | ArrayBuffer | null = null;

  constructor(
    private userService: UserService,
    private emplacementService: EmplacementService,
    private router: Router
  ) {}

  ngOnInit(): void {
    const storedUser = localStorage.getItem('user');
    if (!storedUser) {
      this.router.navigate(['/login']);
      return;
    }

    const parsedUser = JSON.parse(storedUser);

  // Chargement de nouvelles données utilisateur à partir de l'API
  this.userService.getUserById(parsedUser.id).subscribe({
    next: (userData) => {
      this.user = userData;

      // Chargement de tous les pays
      this.emplacementService.getPays().subscribe({
        next: (paysList) => {
          this.paysList = paysList;
          this.selectedPays = this.user.pays || '';

          // Chargement des villes du pays sélectionné
          if (this.selectedPays) {
            this.loadVilles(this.selectedPays);
          }
        },
        error: () => (this.error = 'Erreur lors du chargement des pays.')
      });
    },
    error: () => this.router.navigate(['/login'])
  });
}

  loadVilles(pays: string): void {
    this.emplacementService.getVilles(pays).subscribe({
      next: (res) => {
        this.villes = res;
        const villeTrouvee = this.villes.find(v => v.ville === this.user.ville);
        if (villeTrouvee) this.selectedVille = villeTrouvee.id.toString();
      },
      error: () => (this.error = 'Erreur lors du chargement des villes.')
    });
  }

  onPaysChange(event: any): void {
    const pays = event.target.value;
    this.selectedPays = pays;
    this.villes = [];
    this.selectedVille = '';
    if (pays) this.loadVilles(pays);
  }

  onPhotoSelected(event: any): void {
    this.selectedPhoto = event.target.files[0];
    if (this.selectedPhoto) {
      const reader = new FileReader();
      reader.onload = (e) => (this.previewUrl = e.target?.result || null);
      reader.readAsDataURL(this.selectedPhoto);
    }
  }

  saveProfile(): void {
    const payload: any = {
      ...this.user,
      pays: this.selectedPays,
      ville: this.selectedVille,
    };

    this.userService.updateUserWithPhoto(this.user.id, payload, this.selectedPhoto).subscribe({
      next: (res) => {
        this.message = 'Profil mis à jour avec succès !';
        localStorage.setItem('user', JSON.stringify(res.user));
        setTimeout(() => this.router.navigate(['/profile']), 1500);
      },
      error: () => (this.error = 'Erreur lors de la mise à jour du profil.')
    });
  }

  cancelEdit(): void {
    this.router.navigate(['/profile']);
  }
}
