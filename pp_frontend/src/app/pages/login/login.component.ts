import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Router, RouterModule } from '@angular/router';

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

  constructor(private router: Router, private http: HttpClient) { }

  ngOnInit() {
    
  }

    login(){
      this.http.post('https://127.0.0.1:8000/api/login', {
      email: this.email,
      password: this.password
    }).subscribe({
      next: (res: any) => {
        
        this.error = '';
        localStorage.setItem('user', JSON.stringify(res.user));
          this.router.navigate(['/profile']);
        },
      error: (err) => {
        this.error = err.error.error || 'Erreur de connexion';
      }
    });
  }
}