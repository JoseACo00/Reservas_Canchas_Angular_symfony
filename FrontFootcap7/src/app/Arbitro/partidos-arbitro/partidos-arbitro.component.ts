import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { NotificationsService } from 'angular2-notifications';
import { ArbitroService } from 'src/app/services/Arbitro/arbitro.service';
import { LoginService } from 'src/app/services/Loggin/login.service';

@Component({
  selector: 'app-partidos-arbitro',
  templateUrl: './partidos-arbitro.component.html',
  styleUrls: ['./partidos-arbitro.component.css']
})
export class PartidosArbitroComponent {


  arbitroId!: number;
  partidos: any[] = [];

  constructor(
    private arbitroService: ArbitroService,
    private loginService: LoginService,
    private router: Router,
    private notifications: NotificationsService
  ) {}

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
   * Método de inicialización del componente.
   * Carga los partidos asignados al árbitro al iniciar el componente.
   */
  ngOnInit(): void {
    const userId = this.loginService.getUserId();
    if (userId === null) {
      // Manejar el caso en el que el userId no está disponible
      console.error('No se pudo obtener el ID del árbitro');
      this.router.navigate(['/Login']);
      return;
    }

    this.arbitroId = userId;
    this.cargarPartidos();
  }

    /**
   * Carga los partidos asignados al árbitro desde el servicio.
   */
  cargarPartidos(): void {
    this.arbitroService.obtenerPartidosArbitro(this.arbitroId).subscribe(
      (data: any) => {
        this.partidos = data;
      },
      (error) => {
        console.error('Error al cargar los partidos:', error);
      }
    );
  }

   /**
   * Actualiza el estado del árbitro para un partido específico.
   * @param partidoId ID del partido.
   * @param estado Nuevo estado del árbitro.
   */
  actualizarEstado(partidoId: number, estado: string): void {
    const data = { estado_arbitro: estado };
    this.arbitroService.actualizarEstadoArbitro(partidoId, data).subscribe(
      res => {
        console.log('Estado del árbitro actualizado:', res);
        this.onSuccess('El estado del arbitro fue actualizado')
        this.cargarPartidos(); // Recargar la lista de partidos
      },
      error => {
        console.error('Error al actualizar el estado del árbitro:', error);
        this.onError('Erro al actuliazar el estado del árbitro');
      }
    );
  }
}
