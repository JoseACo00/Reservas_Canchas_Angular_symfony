
import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { CargardataService } from 'src/app/services/CargarDatos/cargardata.service';
import { AdminService } from 'src/app/services/Admin/admin.service';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-partidos-admin',
  templateUrl: './partidos-admin.component.html',
  styleUrls: ['./partidos-admin.component.css']
})
export class PartidosAdminComponent {


  partidos: any[] = [];
  isAdmin: boolean = false;
  arbitros: any[] = [];

  constructor(private router: Router, private cargarDatos: CargardataService, private loginService: LoginService, private adminService:AdminService) {}

  ngOnInit(): void {
    this.cargarPartidos();
    this.cargarArbitros();
    this.isAdmin = this.loginService.getUserRole() === 'Admin';
  }

  cargarPartidos(): void {
    this.cargarDatos.cargarPartidosAdmin().subscribe(
      (data: any) => {
        this.partidos = data.map((partido: any) => ({ ...partido, editMode: false }));
      },
      (error) => {
        console.error('Error al cargar los partidos:', error);
      }
    );
  }

  cargarArbitros(): void {
    this.adminService.obtenerArbitros().subscribe(
      (data: any) => {
        this.arbitros = data;
      },
      (error) => {
        console.error('Error al cargar los árbitros:', error);
      }
    );
  }

  enableEdit(partido: any): void {
    partido.editMode = true;
  }

  guardarCambios(partido: any): void {
    const updateData = {
      estado_reserva: partido.estadoReserva,
      arbitroId: partido.arbitroId
    };
    this.adminService.editarPartidoReserva(partido.id, updateData).subscribe(
      res => {
        console.log('Estado actualizado:', res);
        partido.editMode = false;
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        console.error('Error al actualizar el estado del partido:', error);
      }
    );
  }

  asignarArbitro(partidoId: number, arbitroId: number): void {
    this.adminService.asignarArbitro(partidoId, arbitroId).subscribe(
      res => {
        console.log('Árbitro asignado:', res);
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        console.error('Error al asignar el árbitro:', error);
      }
    );
  }
}


