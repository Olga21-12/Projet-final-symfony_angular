import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { User } from '../../models/user';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-profile',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit{
  user!: User | null;
  message = '';

  constructor(private userService: UserService, private router: Router, private http: HttpClient) {}

  ngOnInit(): void {
    const storedUser = localStorage.getItem('user');
    if (storedUser) {
      const parsed = JSON.parse(storedUser);
      this.loadUser(parsed.id);
    } else{
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
  
