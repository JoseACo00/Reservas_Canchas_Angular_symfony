import { Route, Router } from '@angular/router';
import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';

@Component({
  selector: 'app-reserva-cancha',
  templateUrl: './reserva-cancha.component.html',
  styleUrls: ['./reserva-cancha.component.css']
})
export class ReservaCanchaComponent {


  constructor(private fb: FormBuilder, private Route: Router){

  }


  formReservaCancha = this.fb.group({
   'fecha_reserva': ['', [Validators.required]], // Fecha en formato yyyy-mm-dd si usas type="date"
    'hora_reserva': ['', [Validators.required]], // Hora en formato HH:MM si usas type="time"
    'hora_fin': ['', [Validators.required]], // Hora en formato HH:MM si usas type="time"
    'arbitro_opcion': ['', [Validators.required]],
    'metodo_pago': ['', [Validators.required]] //Asumir entrada de selección sin validación de formato
    });

    procesar() {
      console.log(this.formReservaCancha.value);
    }


}
