import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RsvpValidationComponent } from './rsvp-validation.component';

describe('RsvpValidationComponent', () => {
  let component: RsvpValidationComponent;
  let fixture: ComponentFixture<RsvpValidationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RsvpValidationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RsvpValidationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
