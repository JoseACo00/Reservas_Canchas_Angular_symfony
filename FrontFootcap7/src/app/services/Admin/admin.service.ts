import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AdminService {

  constructor(private http: HttpClient) { }

  //Creacion de Admin
  url= 'http://localhost:8000/registrarAdmin';
  public createAdmin(data:any){
    return this.http.post(this.url,data)
  }


  //Crear Canchas
  addcancha= 'http://localhost:8000/registrarCancha';
  public addCancha(data:any){
    return this.http.post(this.addcancha,data)
  }

   // Obtener detalles de una cancha por su ID
   obtenerCancha(canchaId: number): Observable<any> {
    const url = `http://localhost:8000/cancha/${canchaId}`;
    return this.http.get<any>(url);
  }

  // Editar una cancha
  editarCancha(canchaId: number, data: any): Observable<any> {
    const url = `http://localhost:8000/cancha/${canchaId}/edit`;
    return this.http.put(url, data);
  }

  // Editar estado de reserva de partido
  editarPartidoReserva(partidoId: number, estadoReserva: string): Observable<any>{
    const url = `http://localhost:8000/partido/${partidoId}/estado`;
    return this.http.put(url, { estado_reserva: estadoReserva });
  }

  // Obtener partido
  obtenerPartido(partidoId:number): Observable<any> {
    const urlGetPartidos = `http://localhost:8000/partido/${partidoId}`;
    return this.http.get<any>(urlGetPartidos);
  }

   // Asignar árbitro a un partido
   asignarArbitro(partidoId: number, arbitroId: number): Observable<any> {
    const url = `http://localhost:8000/partido/${partidoId}/asignarArbitro`;
    return this.http.put(url, { arbitro_id: arbitroId });
  }

  // Obtener lista de árbitros
  obtenerArbitros(): Observable<any> {
    const url = 'http://localhost:8000/cargarArbitros';
    return this.http.get<any>(url);
  }

   // Eliminar cancha
   eliminarCancha(canchaId: number): Observable<any> {
    const url = `http://localhost:8000/Cancha/${canchaId}/delete`;
    return this.http.delete(url);
  }


}
