# Aggregate Design

## Shipment

In a uber-like domain, shipment consists of multiple stops.

An example is a shipment which first stops is to collect the product, and the second one is to deliver it.

### Business rules
  - When a product is ready to be delivered, a shipment is scheduled with all the necessary stops
  - Once the carrier arrives at the first stop, its status switches to "arrived"
  - Once the carrier leaves a stop, its status switches to "departed"
  - Once all the stops have been departed, the shipment is considered as delivered
  - A carrier can not skip a stop

### Example

#### Successfully perform all the necessary stops
Time      Restaurant A      Customer
10:00      In transit      In transit
10:08      Arrived         In transit
10:12      Departed        In transit
10:30      Departed        Arrived
10:31      Departed        Departed

#### Fail to skip a stop
Time      Restaurant A    Restaurant B      Customer
22:04      In transit      In transit      In transit
22:09      Arrived         In transit      In transit
22:29      Departed        In transit      In transit
22:43      Departed        In transit      Arrived      XXX Error: carrier has missed a stop to Restaurant B !!
