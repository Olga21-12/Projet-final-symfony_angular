import { CommonModule } from '@angular/common';
import { Component, HostListener, OnInit } from '@angular/core';
import { Router, RouterLinkActive, RouterModule } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, RouterLinkActive, CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent implements OnInit {

user: any = null;

  constructor(private router: Router, private authService: AuthService) {}

  ngOnInit(): void {
    this.authService.user$.subscribe(user => {
      this.user = user;
    });
  }

  logout() {
    this.authService.clearUser();
    this.router.navigate(['/login']);
  }

  hasRole(role: string): boolean {
    const r = this.user?.roles ?? this.user?.role;
    if (Array.isArray(r)) return r.includes(role);
    if (typeof r === 'string') return r === role || r.toLowerCase() === 'propriétaire';
    return false;
  }
  
}