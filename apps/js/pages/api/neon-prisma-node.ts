import type { NextApiRequest, NextApiResponse } from "next";
import { neon } from "@neondatabase/serverless";
import { PrismaNeonHTTP } from "@prisma/adapter-neon";
import { PrismaClient } from '@/prisma-neon/prisma-client'


// Use the WebSocket connection of the Serverless Driver
// const pool = new Pool({ connectionString: process.env.NEON_DATABASE_URL })
// const adapter = new PrismaNeon(pool)

// Use the HTTP connection of the Serverless Driver
const client = neon(process.env.NEON_DATABASE_URL);
const adapter = new PrismaNeonHTTP(client);
const prisma = new PrismaClient({ adapter });

const start = Date.now();

export default async function handler (req: NextApiRequest, res: NextApiResponse) {
  const { count } = req.query;
  const time = Date.now();

  let data = null;
  for (let i = 0; i < toNumber(count); i++) {
    data = await prisma.employees.findMany({ take: 10 });
  }

  return res.status(200).json({
    data,
    queryDuration: Date.now() - time,
    invocationIsCold: start === time,
  });
}

// convert a query parameter to a number, applying a min and max, defaulting to 1
function toNumber(queryParam: string | string[] | null, min = 1, max = 5) {
  const num = Number(queryParam);
  return Number.isNaN(num) ? 1 : Math.min(Math.max(num, min), max);
}