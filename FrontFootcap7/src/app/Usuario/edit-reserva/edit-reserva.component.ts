import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-edit-reserva',
  templateUrl: './edit-reserva.component.html',
  styleUrls: ['./edit-reserva.component.css']
})
export class EditReservaComponent {


  constructor(private fb: FormBuilder, private Route: Router){

  }


  formEditReserva = this.fb.group({
    'fecha_reserva': ['', [Validators.required]], // Fecha en formato yyyy-mm-dd si usas type="date"
     'hora_reserva': ['', [Validators.required]], // Hora en formato HH:MM si usas type="time"
     'hora_fin': ['', [Validators.required]], // Hora en formato HH:MM si usas type="time"
     'arbitro_opcion': ['', [Validators.required]],
     'metodo_pago': ['', [Validators.required]] //Asumir entrada de selección sin validación de formato
     });

     procesar() {
      console.log(this.formEditReserva.value);
  }



}
