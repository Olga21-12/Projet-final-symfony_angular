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
  pays: string | null;
  type_bien: string | null;
}

@Injectable({ providedIn: 'root' })
export class RechercheService {
  private apiUrl = 'https://localhost:8000/api/recherches';

  constructor(private http: HttpClient) {}

  getUserRecherches(): Observable<Recherche[]> {
    return this.http.get<Recherche[]>(this.apiUrl, { withCredentials: true });
  }

  saveSearch(filters: any): Observable<any> {
  return this.http.post(`${this.apiUrl}/save`, filters, { withCredentials: true });
}

getUserRecherchesById(userId: number): Observable<Recherche[]> {
  return this.http.get<Recherche[]>(`https://127.0.0.1:8000/api/recherches/user/${userId}`);
}

}
