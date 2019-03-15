import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RsvpConfirmationComponent } from './rsvp-confirmation.component';

describe('RsvpConfirmationComponent', () => {
  let component: RsvpConfirmationComponent;
  let fixture: ComponentFixture<RsvpConfirmationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RsvpConfirmationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RsvpConfirmationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
