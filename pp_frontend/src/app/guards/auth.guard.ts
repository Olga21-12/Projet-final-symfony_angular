import { Injectable } from '@angular/core';
import { CanActivate, Router, UrlTree } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {

  constructor(private router: Router) {}

  canActivate(): boolean | UrlTree {
    const user = localStorage.getItem('user');

    if (user) {
      return true; // L'utilisateur est connecté - accès accordé
    }

    // 🚫 L'utilisateur est un invité - redirection vers la connexion
    alert('Pour voir le détail, veuillez vous connecter ou vous inscrire.');
    return this.router.createUrlTree(['/login']);
  }
}
