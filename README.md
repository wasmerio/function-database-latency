# Wasmer Edge Database Latency

This demo helps observe the latency characteristics of querying different popular data services from [Wasmer Edge](https://wasmer.io/products/edge).

https://db-latency.wasmer.app

## Providers

Here is an overview of all data service providers and the compute locations available in this app:

| Provider       | Edge (Global) | Edge (Regional / US East) |
| :--------------| :------------ | :------------------------ |
| Neon           | ✅            | ✅                        |
| PlanetScale    | ✅            | ✅                        |
| Supabase       | ✅            | ✅                        |
| TiDB Cloud     | ✅            | ✅                        |
| Xata           | ✅            | ✅                        |

## Testing Methodology

1. Smallest atomic unit, e.g. 1 item / row.
2. Data schema:

```ts
interface EmployeeTable {
  emp_no: number;
  first_name: string;
  last_name: string;
}
```

You can find the instructions for setting up the database inside of [db](./db/)
