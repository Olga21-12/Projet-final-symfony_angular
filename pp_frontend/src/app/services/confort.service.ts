import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ConfortService {
  private apiUrl = 'https://127.0.0.1:8000/api/conforts';

  constructor(private http: HttpClient) {}

  getConforts(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }
}
