import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Emplacement } from '../models/emplacement';

@Injectable({
  providedIn: 'root'
})

export class EmplacementService {
  private baseUrl = 'https://127.0.0.1:8000/api';

  constructor(private http: HttpClient) {}

  // Obtenez une liste de tous les pays
  getPays(): Observable<string[]> {
    return this.http.get<string[]>(`${this.baseUrl}/pays`);
  }

  // Obtenez une liste de toutes les villes pour un pays donné
  getVilles(pays: string): Observable<Emplacement[]> {
    return this.http.get<Emplacement[]>(`${this.baseUrl}/villes?pays=${encodeURIComponent(pays)}`);
  }
}

