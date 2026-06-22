import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';

export async function GET(
  request: Request,
  { params }: { params: Promise<{ id: string }> }
) {
  const { id } = await params;
  const ticket = await prisma.ticket.findUnique({
    where: { id },
    include: {
      agent: { select: { id: true, name: true, email: true } },
      messages: { orderBy: { createdAt: 'asc' } },
      payment: true,
    },
  });
  if (!ticket) return NextResponse.json({ error: 'Not found' }, { status: 404 });
  return NextResponse.json(ticket);
}

export async function PATCH(
  request: Request,
  { params }: { params: Promise<{ id: string }> }
) {
  const { id } = await params;
  const body = await request.json();
  const ticket = await prisma.ticket.update({
    where: { id },
    data: body,
    include: { agent: { select: { id: true, name: true, email: true } } },
  });
  return NextResponse.json(ticket);
}
