Morris.Bar ({
  element: 'grafico-bar-1',
  data: [
	{device: 'Total', geekbench: 300},
	{device: 'Sin atender', geekbench: 50},
	{device: 'Pendientes', geekbench: 50},
	{device: 'Cerrado', geekbench: 200}
  ],
  xkey: 'device',
  ykeys: ['geekbench'],
  labels: ['Cantidad'],
  barRatio: 0.4,
  xLabelAngle: 35,
  hideHover: 'auto'
});

Morris.Bar ({
  element: 'grafico-bar-2',
  data: [
	{device: 'Total', geekbench: 300},
	{device: 'Sin atender', geekbench: 50},
	{device: 'Pendientes', geekbench: 50},
	{device: 'Cerrado', geekbench: 200}
  ],
  xkey: 'device',
  ykeys: ['geekbench'],
  labels: ['Cantidad'],
  barRatio: 0.4,
  xLabelAngle: 35,
  hideHover: 'auto'
});
