import { createServer } from 'http';
import { parse } from 'url';
import next from 'next';
import { Server as SocketIOServer } from 'socket.io';

const dev = process.env.NODE_ENV !== 'production';
const app = next({ dev });
const handle = app.getRequestHandler();

app.prepare().then(() => {
  const httpServer = createServer((req, res) => {
    const parsedUrl = parse(req.url!, true);
    handle(req, res, parsedUrl);
  });

  const io = new SocketIOServer(httpServer, {
    cors: { origin: '*', methods: ['GET', 'POST'] },
  });

  io.on('connection', (socket) => {
    // Join a ticket room
    socket.on('join-room', (ticketId: string) => {
      socket.join(ticketId);
      socket.data.ticketId = ticketId;
      // Notify others in room that someone joined (for agent:ready signaling)
      socket.to(ticketId).emit('peer:joined');
    });

    // WebRTC signaling
    socket.on('screen:offer', ({ ticketId, offer }: { ticketId: string; offer: RTCSessionDescriptionInit }) => {
      socket.to(ticketId).emit('screen:offer', offer);
    });

    socket.on('screen:answer', ({ ticketId, answer }: { ticketId: string; answer: RTCSessionDescriptionInit }) => {
      socket.to(ticketId).emit('screen:answer', answer);
    });

    socket.on('ice:candidate', ({ ticketId, candidate }: { ticketId: string; candidate: RTCIceCandidateInit }) => {
      socket.to(ticketId).emit('ice:candidate', candidate);
    });

    // Ticket status updates - broadcast to room when ticket status changes
    socket.on('ticket:status', ({ ticketId, status }: { ticketId: string; status: string }) => {
      io.to(ticketId).emit('ticket:status', status);
    });

    // Chat messages - broadcast to room
    socket.on('chat:message', ({ ticketId, message }: { ticketId: string; message: unknown }) => {
      socket.to(ticketId).emit('chat:message', message);
    });
  });

  const port = parseInt(process.env.PORT || '3000', 10);
  httpServer.listen(port, () => {
    console.log(`> Ready on http://localhost:${port}`);
  });
});
