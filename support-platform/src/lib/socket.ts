// Socket.IO client stub — wire up when ready to implement real-time
// To enable: npm install socket.io-client, then uncomment the real implementation below.
//
// import { io, Socket } from 'socket.io-client';
//
// let socket: Socket | null = null;
//
// export function getSocket(): Socket {
//   if (!socket) {
//     socket = io(process.env.NEXT_PUBLIC_APP_URL || 'http://localhost:3000', {
//       path: '/api/socketio',
//       transports: ['websocket', 'polling'],
//     });
//   }
//   return socket;
// }
//
// export function disconnectSocket(): void {
//   if (socket) {
//     socket.disconnect();
//     socket = null;
//   }
// }

// MVP: using HTTP polling instead of WebSockets for simplicity
export function getSocket() {
  return null;
}

export function disconnectSocket() {
  // no-op
}
