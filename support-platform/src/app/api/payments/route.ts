import { NextResponse } from 'next/server';
import { prisma } from '@/lib/prisma';
import { v4 as uuidv4 } from 'uuid';

export async function POST(request: Request) {
  const { ticketId } = await request.json();
  if (!ticketId) return NextResponse.json({ error: 'ticketId required' }, { status: 400 });

  const ticket = await prisma.ticket.findUnique({ where: { id: ticketId } });
  if (!ticket) return NextResponse.json({ error: 'Ticket not found' }, { status: 404 });

  // TODO: integrate real payment provider (Stripe/Razorpay)
  // Replace this mock payment block with:
  // const paymentIntent = await stripe.paymentIntents.create({ amount: ticket.amountPaid * 100, currency: 'usd' });
  // Then confirm on client with stripe.confirmPayment(...)

  await new Promise(resolve => setTimeout(resolve, 2000)); // Simulate processing

  const transactionRef = `MOCK-${uuidv4().slice(0, 8).toUpperCase()}`;
  const payment = await prisma.payment.create({
    data: {
      ticketId,
      amount: ticket.amountPaid,
      provider: 'mock',
      status: 'completed',
      transactionRef,
    },
  });

  await prisma.ticket.update({
    where: { id: ticketId },
    data: { status: 'queued' },
  });

  return NextResponse.json({ payment, transactionRef });
}
