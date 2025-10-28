import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Recherche {
  id: number;
  mot_cle: string | null;
  ville: string | null;
  budget_max: number | null;
  surface_max: number | null;
  nombre_de_chambres: number | null;
  created_at: string;
}

@Injectable({ providedIn: 'root' })
export class RechercheService {
  private apiUrl = 'https://localhost:8000/api/recherches';

  constructor(private http: HttpClient) {}

  getUserRecherches(): Observable<Recherche[]> {
    return this.http.get<Recherche[]>(this.apiUrl, { withCredentials: true });
  }
}
