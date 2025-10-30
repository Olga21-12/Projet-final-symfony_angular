import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

export interface Bien {
  id: number;
  adresse: string;
  description: string;
  prix: number;
  surface: number;
  nombre_de_chambres: number;
  disponibilite: boolean;
  luxe: boolean;
  type: number | { id: number; type_de_bien: string } | number;
  activite: number | { id: number; type_activite?: string; name?: string; nom?: string } | number;
  emplacement: {
    pays: string;
    ville: string;
  };
  conforts: number[];
  photos: string[];
  created_at: string;
  updated_at: string;
  proprietaire?: {
    id: number;
    nom: string;
    prenom: string;
    surnom: string;
    email: string;
  };
  created_ago: number;

  // Ajout de la clé simplifiée pour le pipe de prix
  activite_key?: 'short' | 'long' | 'sale' | null;
}

@Injectable({ providedIn: 'root' })
export class BienService {
  private apiUrl = 'https://127.0.0.1:8000/api/biens';

  constructor(private http: HttpClient) {}

  getAllBiens(): Observable<Bien[]> {
    return this.http.get<Bien[]>(this.apiUrl);
  }

  getTotalBiens(): Observable<number>{
    return this.http.get<{ total: number }>(`${this.apiUrl}/count`).pipe(
      map(response => response.total)
    );
  }

  getBienById(id: number): Observable<Bien> {
    return this.http.get<Bien>(`${this.apiUrl}/${id}`);
  }

  deleteBien(id: number): Observable<any> {
    const token = localStorage.getItem('token');
    const headers = token ? { Authorization: `Bearer ${token}` } : {};
    return this.http.delete(`${this.apiUrl}/${id}`, { withCredentials: true });
  }

  createBien(data: any, photos: File[]): Observable<any> {
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== undefined && data[key] !== null) {
      if (Array.isArray(data[key])) {
        data[key].forEach((val) => formData.append(`${key}[]`, val));
      } else {
        formData.append(key, data[key]);
      }
    }
  }

    photos.forEach((photo) => formData.append('photos[]', photo));

    return this.http.post(`${this.apiUrl}`, formData, { withCredentials: true });
  }

  updateBien(id: number, data: any, photos: File[]): Observable<any> {
  const formData = new FormData();

  for (const key in data) {
    if (data[key] !== undefined && data[key] !== null) {
      if (Array.isArray(data[key])) {
        data[key].forEach((val) => formData.append(`${key}[]`, val));
      } else {
        formData.append(key, data[key]);
      }
    }
  }

  (photos || []).slice(0, 4).forEach((file) => {
    formData.append('photos[]', file, file.name);
  });

  return this.http.post(`${this.apiUrl}/${id}?_method=PUT`, formData, { withCredentials: true });
}

  getBiensByUserId(userId: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/user/${userId}`, { withCredentials: true });
  }

  getPaginatedBiens(page: number, limit: number): Observable<{ items: Bien[], pagination: any }> {
    return this.http.get<{ items: Bien[], pagination: any }>(
      `${this.apiUrl}?page=${page}&limit=${limit}`,
      { withCredentials: true }
    );
  }

  shortRent(bienId: number, durationDays: number) {
    return this.http.post<{message: string}>(
      `${this.apiUrl}/${bienId}/short-rent`,
      { durationDays },
      { withCredentials: true }
    );
  }

  longRent(bienId: number) {
    return this.http.post<{message: string}>(
      `${this.apiUrl}/${bienId}/long-rent`,
      {},
      { withCredentials: true }
    );
  }

  buy(bienId: number) {
    return this.http.post<{message: string}>(
      `${this.apiUrl}/${bienId}/buy`,
      {},
      { withCredentials: true }
    );
  }

  getFilteredBiens(filters: any): Observable<any> {
    let params = new HttpParams();

    for (const key of Object.keys(filters)) {
      const value = filters[key];

      if (value !== null && value !== '' && value !== undefined) {
        params = params.set(key, String(value)); // 👈 все как строки
      }
    }

    return this.http.get(`${this.apiUrl}/filtre`, { params });
  }

}

