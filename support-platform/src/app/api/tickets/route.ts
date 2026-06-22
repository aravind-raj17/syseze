import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { getServerSession } from 'next-auth';
import { authOptions } from '@/lib/auth';

export async function GET() {
  const session = await getServerSession(authOptions);
  if (!session) {
    return NextResponse.json({ error: 'Unauthorized' }, { status: 401 });
  }
  const tickets = await prisma.ticket.findMany({
    where: { status: { in: ['queued', 'assigned', 'in_session', 'awaiting_confirmation'] } },
    include: { agent: { select: { id: true, name: true, email: true } }, payment: true },
    orderBy: { createdAt: 'asc' },
  });
  return NextResponse.json(tickets);
}

export async function POST(request: Request) {
  const body = await request.json();
  const { customerName, customerEmail, customerPhone, issueCategory, issueDescription, hoursPurchased } = body;
  if (!customerName || !customerEmail || !issueCategory || !issueDescription || !hoursPurchased) {
    return NextResponse.json({ error: 'Missing required fields' }, { status: 400 });
  }
  const PRICE_PER_HOUR = 49;
  const amountPaid = hoursPurchased * PRICE_PER_HOUR;
  const count = await prisma.ticket.count();
  const ticketNumber = `TKT-${new Date().getFullYear()}-${String(count + 1).padStart(5, '0')}`;
  const ticket = await prisma.ticket.create({
    data: {
      ticketNumber,
      customerName,
      customerEmail,
      customerPhone: customerPhone || null,
      issueCategory,
      issueDescription,
      hoursPurchased,
      amountPaid,
      status: 'pending_payment',
    },
  });
  return NextResponse.json(ticket, { status: 201 });
}
