// receipt.js - Generate PDF receipt using jsPDF
// Usage: generateReceipt(paymentObj)

function generateReceipt(payment) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.setFontSize(16);
  doc.text('Clinic Name: Your Clinic', 10, 10);
  doc.text('Doctor Name: Dr. John Doe', 10, 20);
  doc.setFontSize(12);
  doc.text(`Patient Name: ${payment.patientName}`, 10, 35);
  doc.text(`Patient ID: ${payment.patientId}`, 10, 43);
  if(payment.appointmentId) doc.text(`Appointment ID: ${payment.appointmentId}`, 10, 51);
  doc.text(`Amount: ₹${payment.amount}`, 10, 59);
  doc.text(`Payment Method: ${payment.paymentMethod}`, 10, 67);
  doc.text(`Status: ${payment.status}`, 10, 75);
  doc.text(`Date: ${payment.dateTime}`, 10, 83);
  if(payment.notes) doc.text(`Notes: ${payment.notes}`, 10, 91);
  // Digital signature (simple text, can be replaced with image)
  doc.text('Signature: ___________________', 10, 110);
  doc.save(`Receipt_${payment.patientName}_${payment.dateTime}.pdf`);
}
