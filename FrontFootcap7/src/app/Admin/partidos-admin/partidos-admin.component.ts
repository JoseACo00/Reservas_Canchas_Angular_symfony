
import { Component, OnInit, OnDestroy } from '@angular/core';
import { Router } from '@angular/router';
import { CargardataService } from 'src/app/services/CargarDatos/cargardata.service';
import { AdminService } from 'src/app/services/Admin/admin.service';
import { LoginService } from 'src/app/services/Loggin/login.service';
import { NotificationsService } from 'angular2-notifications';

@Component({
  selector: 'app-partidos-admin',
  templateUrl: './partidos-admin.component.html',
  styleUrls: ['./partidos-admin.component.css']
})
export class PartidosAdminComponent {


  partidos: any[] = [];
  isAdmin: boolean = false;
  arbitros: any[] = [];

  constructor(private router: Router, private cargarDatos: CargardataService, private loginService: LoginService, private adminService:AdminService,private notifications: NotificationsService ) {}


  /**
   * Método de inicialización del componente.
   * Carga los partidos y árbitros.
   */
  ngOnInit(): void {
    this.cargarPartidos();
    this.cargarArbitros();
    this.isAdmin = this.loginService.getUserRole() === 'Admin';

  }

  //MENSJAES DE ERROR
  onError(message: string) {
    this.notifications.error('Error', message, {
      position: ["top", "center"], // Configuración de posición
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 4000
    });
  }

   onSuccess(message: string) {
    this.notifications.success('SUCCESS', message, {
      position: ['top', 'middle'],
      animate: 'fromTop',
      showProgressBar: true,
      timeOut: 2000
    });
  }
 /**
   * Carga la lista de árbitros desde el servicio.
   */
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

  /**
   * Habilita el modo de edición para un partido específico.
   * @param partido Partido a editar.
   */
  enableEdit(partido: any): void {
    partido.editMode = true;
  }

   /**
   * Guarda los cambios realizados en un partido.
   * @param partido Partido con los cambios a guardar.
   */

  guardarCambios(partido: any): void {
    const updateData = {
      estado_reserva: partido.estadoReserva,
      arbitroId: partido.arbitroId
    };
    this.adminService.editarPartidoReserva(partido.id, updateData).subscribe(
      res => {
        this.onSuccess('Estado acutliazo')
        console.log('Estado actualizado:', res);
        partido.editMode = false;
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        this.onError('Error al actulizar el estado del partido')
        console.error('Error al actualizar el estado del partido:', error);
      }
    );
  }

  /**
   * Asigna un árbitro a un partido.
   * @param partidoId ID del partido.
   * @param arbitroId ID del árbitro.
   */
  asignarArbitro(partidoId: number, arbitroId: number): void {
    this.adminService.asignarArbitro(partidoId, arbitroId).subscribe(
      res => {
        this.onSuccess('Arbitro fue asignado');
        console.log('Árbitro asignado:', res);
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        this.onError('Error al asinganr el árbitro')
        console.error('Error al asignar el árbitro:', error);
      }
    );
  }
}


