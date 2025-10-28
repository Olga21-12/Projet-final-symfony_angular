import { MesBiensComponent } from './../../components/mes-biens/mes-biens.component';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { User } from '../../models/user';
import { UserService } from '../../services/user.service';
import { Recherche, RechercheService } from '../../services/recherche.service';

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [CommonModule, RouterModule, MesBiensComponent],
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit{
  user!: User | null;
  message = '';
  activeTab = '';

  recherches: Recherche[] = [];

  constructor(private userService: UserService, 
              private router: Router, 
              private http: HttpClient,
              private rechercheService: RechercheService) {}

  ngOnInit(): void {
    if (localStorage.getItem('emailVerified') === 'true') {
      this.message = '✅ Votre adresse e-mail a été confirmée avec succès !';
      localStorage.removeItem('emailVerified');
    }
  
  const storedUser = localStorage.getItem('user');
    if (storedUser) {
      const parsedUser = JSON.parse(storedUser);
      if (parsedUser?.id) {
        this.loadUser(parsedUser.id);
        this.loadRecherches();
      } else {
        console.warn('Aucun ID utilisateur trouvé');
      }
    } else {
      console.warn('Aucun utilisateur en localStorage');
      this.router.navigate(['/login']);
    }
  }

  loadUser(id: number) {
  this.userService.getUserById(id).subscribe({
    next: (data: User) => {
      console.log('Profil reçu:', data);
      this.user = data;
    },
    error: (err) => {
      console.error('Erreur chargement profil:', err);
      this.router.navigate(['/login']);
    }
  });
}

// Загружаем сохранённые поиски
  loadRecherches() {
    this.rechercheService.getUserRecherches().subscribe({
      next: (data) => {
        this.recherches = data;
      },
      error: () => {
        this.recherches = [];
      }
    });
  }

  editProfile() {
    this.router.navigate(['/edit-profile']);
  }

  deleteProfile() {
    if (confirm('Voulez-vous vraiment supprimer votre profil ?')) {
      const storedUser = localStorage.getItem('user');

      if (!storedUser) return;

      const user = JSON.parse(storedUser);

      this.userService.deleteUser(user.id).subscribe({
        next: () => {
          alert('Profil supprimé avec succès.');
          localStorage.clear();
          this.router.navigate(['/register']);
        },
        error: (err) => {
          console.error('Erreur suppression profil:', err);
          alert("Une erreur est survenue lors de la suppression du profil.");
        }
      });
    }
  }  
}
