import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

export interface Bien {
  id: number;
  adresse: string;
  description: string;
  prix: number;
  surface: number;
  nombre_de_chambres: number;
  disponibilite: boolean;
  luxe: boolean;
  type: string;
  activite: string;
  emplacement: {
    pays: string;
    ville: string;
  };
  conforts: string[];
  photos: string[];
  created_at: string;
  updated_at: string;
}

@Injectable({ providedIn: 'root' })
export class BienService {
  private apiUrl = 'https://127.0.0.1:8000/api/biens';

  constructor(private http: HttpClient) {}

  getAllBiens(): Observable<Bien[]> {
    return this.http.get<Bien[]>(this.apiUrl);
  }
}

