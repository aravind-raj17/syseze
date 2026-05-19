import { PrismaClient } from '@prisma/client';
import { PrismaPg } from '@prisma/adapter-pg';
import bcrypt from 'bcryptjs';
import * as dotenv from 'dotenv';
import path from 'path';

dotenv.config({ path: path.resolve(process.cwd(), '.env') });

const connectionString = process.env.DATABASE_URL;
if (!connectionString) {
  throw new Error('DATABASE_URL environment variable is not set');
}
const adapter = new PrismaPg({ connectionString });
const prisma = new PrismaClient({ adapter });

async function main() {
  const existing = await prisma.user.findUnique({ where: { email: 'agent@demo.com' } });
  if (!existing) {
    await prisma.user.create({
      data: {
        email: 'agent@demo.com',
        passwordHash: await bcrypt.hash('demo123', 10),
        name: 'Demo Agent',
        role: 'agent',
        isAvailable: true,
      },
    });
    console.log('Created demo agent: agent@demo.com / demo123');
  } else {
    console.log('Demo agent already exists');
  }
}

main().catch(console.error).finally(() => prisma.$disconnect());
