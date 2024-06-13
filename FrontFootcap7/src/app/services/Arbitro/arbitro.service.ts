import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ArbitroService {



  private baseUrl = 'http://localhost:8000';

  constructor(private http: HttpClient) { }

  url= 'http://localhost:8000/registroArbitro';

  public registarArbitro(data:any) {

    return this.http.post(this.url,data);
  }

  //EditarExperiencias

  obtenerArbitro(arbitroId: number): Observable<any> {
    const url = `${this.baseUrl}/arbitro/${arbitroId}`;
    return this.http.get<any>(url);
  }

  editarArbitro(arbitroId: number, data: any): Observable<any> {
    const url = `${this.baseUrl}/arbitro/${arbitroId}/edit`;
    return this.http.put<any>(url, data);
  }

  obtenerPartidosArbitro(arbitroId: number): Observable<any> {
    const url = `${this.baseUrl}/arbitro/${arbitroId}/partidos`;
    return this.http.get<any>(url);
  }

  actualizarEstadoArbitro(partidoId: number, data: any): Observable<any> {
    const url = `${this.baseUrl}/partido/${partidoId}/estado_arbitro`;
    return this.http.put<any>(url, data);
  }

}
