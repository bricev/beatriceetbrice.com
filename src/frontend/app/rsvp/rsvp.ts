export class Group {
    identifier: string;
    name: string;
    guests: Guest[];
}

export class Guest {
    name: string;
    sex: string;
    age: number;
}

export class Confirmation {
    identifier: string;
    comingGuests: Guest[];
    needBabysitter: boolean;
    needDriver: boolean;
    hasAllergy: boolean;
    favorite60sTube: string;
    favorite70sTube: string;
    favorite80sTube: string;
    favoriteContemporaryTube: string;
}

export class Rsvp {
    group: Group;
    rsvp: Confirmation | null;
}
