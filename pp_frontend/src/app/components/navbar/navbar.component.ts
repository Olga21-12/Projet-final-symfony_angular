import { CommonModule } from '@angular/common';
import { Component, HostListener, OnInit } from '@angular/core';
import { Router, RouterLinkActive, RouterModule } from '@angular/router';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterModule, RouterLinkActive, CommonModule],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css'
})
export class NavbarComponent implements OnInit {

user: any = null;

  constructor(private router: Router) {}

  ngOnInit(): void {
    const storedUser = localStorage.getItem('user');
    if (storedUser){
      this.user = JSON.parse(storedUser);
    }
  }

  loadUser() {
    const storedUser = localStorage.getItem('user');
    this.user = storedUser ? JSON.parse(storedUser) : null;
  }

  logout() {
    // Suppression des données utilisateur
    localStorage.removeItem('user');
    localStorage.removeItem('isLoggedIn');
    this.user = null;

    // Redirection vers la page de connexion
    this.router.navigate(['/login']);
  }

 // scrolled = false;

  // слушаем событие прокрутки окна
//  @HostListener('window:scroll', [])
//  onWindowScroll() {
//    this.scrolled = window.scrollY > 50;
//  }
}
