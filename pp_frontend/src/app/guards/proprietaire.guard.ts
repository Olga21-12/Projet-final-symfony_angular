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

    if (!user) {
    this.router.navigate(['/login'], {
      queryParams: { message: 'Vous devez être propriétaire pour ajouter un bien.' }
    });
    return false;
  }

  // "Propriétaire" и "ROLE_PROPRIETAIRE"
  const role = user.role?.toLowerCase();

  if (role === 'propriétaire' || role === 'role_proprietaire') {
    return true;
  }

  this.router.navigate(['/login'], {
    queryParams: { message: 'Vous devez être propriétaire pour ajouter ou modifier un bien.' }
  });
  return false;

  }
}
