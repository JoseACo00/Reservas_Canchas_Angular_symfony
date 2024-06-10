import { AdminService } from 'src/app/services/Admin/admin.service';
import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-editar-partido',
  templateUrl: './editar-partido.component.html',
  styleUrls: ['./editar-partido.component.css']
})
export class EditarPartidoComponent {

  partidoId!: number;

  formEditPartido = this.fb.group({

    'estadoReserva': ['', [Validators.required]]
  })


  constructor (private fb: FormBuilder, private adminService: AdminService, private router:Router,){}
}
