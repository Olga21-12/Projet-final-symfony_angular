import { CommonModule } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule, HttpClientModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {

  email = '';
  password = '';
  message = '';
  error = '';

  constructor(private router: Router, private http: HttpClient) { }

    login(){
      this.http.post('https://127.0.0.1:8000/api/login', {
      email: this.email,
      password: this.password
    }).subscribe({
      next: (res: any) => {
        this.message = res.message;
        this.error = '';
        localStorage.setItem('user', JSON.stringify(res.user));

        // Accéder à la page de profil
        setTimeout(() => {
          this.router.navigate(['/profile']);
        }, 1000);
      },
      error: (err) => {
        this.error = err.error.error || 'Erreur de connexion';
        this.message = '';
      }
    });
  }
}