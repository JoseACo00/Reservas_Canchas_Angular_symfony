import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ListaReservaUsuarioComponent } from './lista-reserva-usuario.component';

describe('ListaReservaUsuarioComponent', () => {
  let component: ListaReservaUsuarioComponent;
  let fixture: ComponentFixture<ListaReservaUsuarioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ListaReservaUsuarioComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ListaReservaUsuarioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
