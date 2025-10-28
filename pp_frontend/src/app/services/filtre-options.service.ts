import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FiltreOptionsService {
  private apiUrl = 'https://localhost:8000/api/filtre/options';

  constructor(private http: HttpClient) {}

  getOptions(): Observable<any> {
    return this.http.get<any>(this.apiUrl);
  }
}
