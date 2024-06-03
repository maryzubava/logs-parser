# Logs Parser

## Installation
For building images:
```bash
make install
```

For starting the application:
```bash
make start
```

## Usage

## Developer notes
It will be better to use column-based database for performance purposes with aggregation on a big datasets like ClickHouse or Cassandra.

## Task

We have an aggregated log file that contains logs from all services, this file size in TBs.
Now we are planning to have a new project to display a dashboard but in order to do that we need you to do the following:

    1.  Write code that reads the aggregated log file and saves it into a database
        a. Please note that other services will continue logging to the same file.
        b. Database modeling is not restricted, pick a schema that works for you. 

    2. Create a service that will have an endpoint /count. The endpoint should return a COUNT of rows that matched the filters criteria.
        a. This endpoint accepts a list of filters via GET request, you can send zero or more filters to the endpoint. The filters are:
            i. serviceNames
            ii. statusCode
            iii. startDate
            iv. endDate
        b. Endpoint result:


Please see the attached api.yaml (OpenAPI specs) for more information.
### Notes:
Aggregated Log file can be found as an attachment to the email related, this log file will only have 20 records as a snapshot for testing purposes.