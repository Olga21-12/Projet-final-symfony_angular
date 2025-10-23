import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ActiviteService {
  private apiUrl = 'https://127.0.0.1:8000/api/activites';

  constructor(private http: HttpClient) {}

  getActivites(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }
}
