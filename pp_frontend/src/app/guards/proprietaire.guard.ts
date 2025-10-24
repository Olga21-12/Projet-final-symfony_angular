import { Injectable } from '@angular/core';
import { CanActivate, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

@Injectable({
  providedIn: 'root'
})
export class ProprietaireGuard implements CanActivate {

  constructor(private authService: AuthService, private router: Router) {}

  canActivate(): boolean {
    const user = this.authService.getUser();

    if (user && user.role === 'ROLE_PROPRIETAIRE') {
      return true;
    } else {
      this.router.navigate(['/login'], { 
        queryParams: { message: 'Vous devez être propriétaire pour ajouter un bien.' } 
      });
      return false;
    }
  }
}
