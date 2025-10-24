import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';
import { AuthService } from '../../services/auth.service';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit {

  email = '';
  password = '';
  error = '';
  message: string | null = null;

  constructor(private route: ActivatedRoute, private router: Router, private http: HttpClient, private authService: AuthService) { }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      this.message = params['message'] || null;
    });
  }

    login() {
  this.http.post('https://127.0.0.1:8000/api/login',
    { email: this.email, password: this.password },
    { headers: { 'Content-Type': 'application/json' } } // 👈 важно!
  ).subscribe({
    next: (res: any) => {
      this.authService.setUser(res.user);
      this.router.navigate(['/profile']);
    },
    error: (err) => {
      console.error('Erreur de connexion:', err);
      this.error = err.error?.error || 'Erreur de connexion';
    }
  });
}
}