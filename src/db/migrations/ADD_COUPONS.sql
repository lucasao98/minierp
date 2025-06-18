INSERT INTO montinkerp.coupons 
VALUES(
	1,
	'10OFF',
	0.10,
	300.00, 
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo'),
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo') + INTERVAL 10 MINUTE
),(
	2,
	'20OFF',
	0.20,
	600.00,
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo'),
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo') + INTERVAL 10 MINUTE
), (
	3,
	'30OFF',
	0.30,
	800.00,
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo'),
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo') + INTERVAL 10 MINUTE
), (
	4,
	'40OFF',
	0.40,
	800.00,
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo'),
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo') + INTERVAL 10 MINUTE
), (
	5,
	'50OFF',
	0.50,
	1000.00,
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo'),
	CONVERT_TZ(NOW(), @@session.time_zone, 'America/Sao_Paulo') + INTERVAL 10 MINUTE
);