import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-verify-email',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  template: `
    <div class="container mt-5 text-center">
      <h2 *ngIf="!error">✨ Vérification en cours...</h2>
      <p *ngIf="message" class="alert alert-success mt-3">{{ message }}</p>
      <p *ngIf="error" class="alert alert-danger mt-3">{{ error }}</p>
    </div>
  `
})
export class VerifyEmailComponent implements OnInit {
  loading = true;
  message = '';
  error = '';

  constructor(private route: ActivatedRoute, private http: HttpClient, private router: Router) {}

  ngOnInit() {
    // Récupère le token depuis l’URL
    const token = this.route.snapshot.queryParamMap.get('token');
    if (token) {
      this.http.get(`https://127.0.0.1:8000/verify/email?token=${encodeURIComponent(token)}`, { responseType: 'text' }).subscribe({
        next: (res: any) => {
          this.message = '✅ Votre adresse e-mail a été vérifiée avec succès !';
      this.error = '';
      // Перенаправляем на страницу логина через 3 секунды
      setTimeout(() => this.router.navigate(['/login']), 2000);
        },
        error: (err) => {
          this.error = err.error.error || 'Lien invalide ou expiré.';
        }
      });
    } else {
      this.error = 'Aucun token fourni.';
    }
  }
}
