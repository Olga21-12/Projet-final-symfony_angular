import { CommonModule } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { UserService } from '../../services/user.service';
import { Router } from '@angular/router';
import { User } from '../../models/user';

@Component({
  selector: 'app-edit-profile',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './edit-profile.component.html',
  styleUrls: ['./edit-profile.component.css']
})
export class EditProfileComponent implements OnInit{

user: User | null = null;
  message = '';
  error = '';

  constructor(private userService: UserService, private router: Router) {}

  ngOnInit(): void {
    const storedUser = localStorage.getItem('user');
    if (!storedUser) {
      this.router.navigate(['/login']);
      return;
    }

    const parsed = JSON.parse(storedUser);
    this.userService.getUserById(parsed.id).subscribe({
      next: (data) => (this.user = data),
      error: () => (this.error = 'Erreur lors du chargement du profil.')
    });
  }

    selectedPhoto?: File;

    onPhotoSelected(event: any) {
      this.selectedPhoto = event.target.files[0];
    }

    saveProfile() {
      if (!this.user) return;

      this.userService.updateUserWithPhoto(this.user.id, this.user, this.selectedPhoto).subscribe({
        next: (res) => {
          this.message = res.message;
          localStorage.setItem('user', JSON.stringify(res.user));
          setTimeout(() => this.router.navigate(['/profile']), 1500);
        },
        error: () => (this.error = 'Erreur lors de la mise à jour du profil.')
      });
    }


  cancelEdit() {
    this.router.navigate(['/profile']);
  }

  
}
