import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Recherche {
  type: 'location' | 'achat';
  bien_id: number;
  adresse: string;
  prix: number;
  date_debut?: string;
  date_fin?: string;
  date_achat?: string;
  photo?: string;
}
@Injectable({
  providedIn: 'root'
})
export class RechercheService {
  private apiUrl = 'https://127.0.0.1:8000/api/user';

  constructor(private http: HttpClient) {}

  getByUser(userId: number): Observable<Recherche[]> {
    return this.http.get<Recherche[]>(`${this.apiUrl}/${userId}/transactions`, { withCredentials: true });
  }
}
