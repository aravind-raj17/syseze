import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';

export async function GET(
  request: Request,
  { params }: { params: Promise<{ ticketId: string }> }
) {
  const { ticketId } = await params;
  const messages = await prisma.message.findMany({
    where: { ticketId },
    orderBy: { createdAt: 'asc' },
  });
  return NextResponse.json(messages);
}

export async function POST(
  request: Request,
  { params }: { params: Promise<{ ticketId: string }> }
) {
  const { ticketId } = await params;
  const { senderType, content } = await request.json();
  if (!senderType || !content) {
    return NextResponse.json({ error: 'Missing fields' }, { status: 400 });
  }
  const message = await prisma.message.create({
    data: { ticketId, senderType, content },
  });
  return NextResponse.json(message, { status: 201 });
}
