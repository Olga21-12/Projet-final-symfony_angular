import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
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
  proprietaire?: {
    id: number;
    nom: string;
    prenom: string;
    surnom: string;
    email: string;
  };
  created_ago: number;
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
    return this.http.delete(`${(this.apiUrl)}/${id}`);
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

    return this.http.post(`${this.apiUrl}`, formData);
  }

  updateBien(id: number, data: any, photos: File[]): Observable<any> {
    const formData = new FormData();

    for (const key in data) {
      if (data[key] !== undefined && data[key] !== null) {
        if (Array.isArray(data[key])) {
          data[key].forEach((val) => formData.append(${key}[], val));
        } else {
          formData.append(key, data[key]);
        }
      }
    }

    photos.forEach((photo) => formData.append('photos[]', photo));

    return this.http.post(${this.apiUrl}/${id}?_method=PUT, formData);
  }
}

