import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-verify-email',
  standalone: true,
  imports: [CommonModule],
  template: ``
})

export class VerifyEmailComponent implements OnInit {
  
  constructor(private route: ActivatedRoute, private http: HttpClient, private router: Router) {}

  ngOnInit() {
    const token = this.route.snapshot.queryParamMap.get('token');
    if (token) {
      this.http.get(`https://127.0.0.1:8000/api/verify-email?token=${encodeURIComponent(token)}`).subscribe({
        next: () => {
          // сохраняем флаг
          localStorage.setItem('emailVerified', 'true');
          // сразу редиректим на логин
          this.router.navigate(['/login']);
        },
        error: () => {
          this.router.navigate(['/login']);
        }
      });
    }
  }
} 
