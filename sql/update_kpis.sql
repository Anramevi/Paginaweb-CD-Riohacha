-- Agregar columnas meta y disparador
ALTER TABLE kpi_definitions 
ADD COLUMN meta VARCHAR(50) AFTER unidad_medida,
ADD COLUMN disparador VARCHAR(50) AFTER meta;

-- Actualizar valores
UPDATE kpi_definitions SET meta = '', disparador = '<= 3 / >= 97' WHERE kpi_impactado = 'TRI' AND indicador = '% Cashless';
UPDATE kpi_definitions SET meta = '<= 1.6', disparador = '>= 2.0' WHERE kpi_impactado = 'OTIF' AND indicador = '% Refusal';
UPDATE kpi_definitions SET meta = '>= 95', disparador = '<= 90' WHERE kpi_impactado = 'OTIF' AND indicador = 'EF. Cargue';
UPDATE kpi_definitions SET meta = '<= 1', disparador = '>= 3' WHERE kpi_impactado = 'OTIF' AND indicador = 'VH. No disponible';
UPDATE kpi_definitions SET meta = '>= 87', disparador = '<= 85' WHERE kpi_impactado = 'NPS' AND indicador = 'Entrega en rango';
UPDATE kpi_definitions SET meta = '>= 95', disparador = '<= 90' WHERE kpi_impactado = 'ONTIME' AND indicador = 'Salidas antes de 7';
UPDATE kpi_definitions SET meta = '>= 5.12', disparador = '<= 4.5' WHERE kpi_impactado = 'TP' AND indicador = 'WNP';
UPDATE kpi_definitions SET meta = '>= 87', disparador = '<= 85' WHERE kpi_impactado = 'Asset Eff' AND indicador = 'Capacity Weight';
UPDATE kpi_definitions SET meta = '0 / 0', disparador = '>= 3' WHERE kpi_impactado = 'Rotación' AND indicador = 'Ausentismo injustificado OL/UC';
UPDATE kpi_definitions SET meta = '0 / 0', disparador = '>= 3' WHERE kpi_impactado = 'SHCO' AND indicador = 'Hectolitros bloqueados';
UPDATE kpi_definitions SET meta = '<= 8', disparador = '>= 10' WHERE kpi_impactado = 'INFULL' AND indicador = 'Errores de armado';
UPDATE kpi_definitions SET meta = '<= 2.5', disparador = '>= 3' WHERE kpi_impactado = 'NPS' AND indicador = 'Fallas de bloqueo';
