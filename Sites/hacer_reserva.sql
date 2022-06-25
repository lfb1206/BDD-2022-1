create or replace function hacer_reserva(id_vuelo, pasaportes varchar[]) returns void as $$
declare
    cnt integer;
    pass Pasajero%rowtype;
    to_reserve Vuelo%rowtype;
begin
    select *
    into to_reserve
    from Vuelo
    where Vuelo.id_vuelo = id_vuelo;

    for p in pasaportes loop
        if p = '' then
            continue;
        end if;

        select *
        into pass
        from Pasajero
        where Pasajero.pasaporte = p;

        if not found then
            return format('El pasaporte "%s" es inválido', p);
        end if;

        if exists(
            select *
            from Ticket, Vuelo
            where Ticket.id_pasajero = pass.id_pasajero
                and Ticket.id_vuelo = Vuelo.id_vuelo
                and Vuelo.fecha_salida <= to_reserve.fecha_llegada
                and Vuelo.fecha_llegada <= to_reserve.fecha_salida
        ) then
            return format('El pasajero %s tiene un tope de horario', p);
        end if;
    end loop;
    
    
    if array_length(pasaportes, 1) == 0 then
        return 'Se debe ingresar al menos 1 pasaporte';
    end if;
end;
$$ language plpgsql