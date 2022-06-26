create or replace function hacer_reserva(pasaporte_reservador varchar, id_vuelo_a_reservar integer, pasaportes varchar[])
returns varchar as $$
declare
    cnt integer;
    p varchar;
    passenger Pasajero%rowtype;
    reserver Pasajero%rowtype;
    to_reserve Vuelo%rowtype;
    passenger_count integer := 0;
    reservation_id integer;
begin
    select *
    into to_reserve
    from Vuelo
    where Vuelo.id_vuelo = id_vuelo_a_reservar;

    if not found then
        return format('!El vuelo con id %s no existe', id_vuelo_a_reservar);
    end if;

    select *
    into reserver
    from Pasajero
    where Pasajero.pasaporte = pasaporte_reservador;

    if not found then
        return format('!Pasaporte del reservador "%s" no existe', pasaporte_reservador);
    end if;

    foreach p in array pasaportes loop
        if p = '' then
            continue;
        end if;

        select *
        into passenger
        from Pasajero
        where Pasajero.pasaporte = p;

        if not found then
            return format('!El pasaporte "%s" es inválido', p);
        end if;

        if exists(
            select *
            from Ticket, Vuelo
            where Ticket.id_pasajero = passenger.id_pasajero
                and Ticket.id_vuelo = Vuelo.id_vuelo
                and Vuelo.fecha_salida <= to_reserve.fecha_llegada
                and Vuelo.fecha_llegada >= to_reserve.fecha_salida
        ) then
            return format('!El pasajero %s (%s) tiene un tope de horario', passenger.nombre, passenger.pasaporte);
        end if;

        passenger_count := passenger_count + 1;
    end loop;

    if passenger_count = 0 then
        return '!Se debe ingresar al menos 1 pasaporte';
    end if;

    insert into Reserva(id_reservador)
    values (reserver.id_pasajero)
    returning id_reserva into reservation_id;

    insert into Ticket(id_reserva, id_pasajero, id_vuelo, numero_asiento, clase, incluye_comida_y_maleta)
    select reservation_id, Pasajero.id_pasajero, id_vuelo_a_reservar, 1 + floor(random() * 32), 'Economica', true
    from Pasajero
    where Pasajero.pasaporte = any(pasaportes);

    return format('+Se creo una reserva para %s pasajeros', passenger_count);
end;
$$ language plpgsql;
