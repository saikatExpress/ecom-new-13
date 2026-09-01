<?php

namespace Database\Seeders\CMS;

use App\Models\CMS\Faq;
use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [

            [
                'question' => 'How can I place an order?',
                'answer' => '
                    <p>
                        You can place an order directly from our website. Select your desired
                        product, choose the quantity or available variation, add it to your cart,
                        and proceed to checkout. Provide your name, phone number, delivery address,
                        and select your preferred payment method. Finally, review your order and
                        confirm it.
                    </p>
                ',
                'position' => 1,
            ],

            [
                'question' => 'Do I need to create an account to place an order?',
                'answer' => '
                    <p>
                        No. You do not need to create an account or log in to place an order.
                        You can complete your purchase using your phone number and delivery
                        information.
                    </p>
                ',
                'position' => 2,
            ],

            [
                'question' => 'What payment methods do you accept?',
                'answer' => '
                    <p>
                        We support multiple payment methods depending on availability, including
                        Cash on Delivery, bKash, Nagad, Rocket, and other available payment
                        options shown during checkout.
                    </p>
                ',
                'position' => 3,
            ],

            [
                'question' => 'Is Cash on Delivery available?',
                'answer' => '
                    <p>
                        Yes, Cash on Delivery is available for eligible delivery areas and products.
                        You can select Cash on Delivery during checkout if the option is available
                        for your order.
                    </p>
                ',
                'position' => 4,
            ],

            [
                'question' => 'How much does delivery cost?',
                'answer' => '
                    <p>
                        Delivery charges depend on your delivery location and the applicable
                        delivery service. The exact delivery fee will be displayed during checkout
                        before you confirm your order.
                    </p>
                ',
                'position' => 5,
            ],

            [
                'question' => 'How long does delivery take?',
                'answer' => '
                    <p>
                        Delivery time depends on your location and courier service.
                        Orders inside Dhaka are generally delivered within 1-2 working days,
                        while orders outside Dhaka may take approximately 2-5 working days.
                    </p>

                    <p>
                        Delivery time may be longer during public holidays, campaigns, adverse
                        weather, courier delays, or other unforeseen circumstances.
                    </p>
                ',
                'position' => 6,
            ],

            [
                'question' => 'Can I track my order?',
                'answer' => '
                    <p>
                        Yes, once your order is handed over to the courier, tracking information
                        may become available. You can use the tracking information provided by
                        our support team or courier service to check your delivery status.
                    </p>
                ',
                'position' => 7,
            ],

            [
                'question' => 'Can I cancel my order after placing it?',
                'answer' => '
                    <p>
                        You may request cancellation as soon as possible after placing your order.
                        Cancellation may not be possible once the order has been processed,
                        packed, or handed over to the courier.
                    </p>

                    <p>
                        To request a cancellation, contact our customer support team and provide
                        your order number and phone number.
                    </p>
                ',
                'position' => 8,
            ],

            [
                'question' => 'Can I change my delivery address after placing an order?',
                'answer' => '
                    <p>
                        You may request an address change before the order is dispatched.
                        Once the order has been handed over to the courier, changing the delivery
                        address may not be possible.
                    </p>

                    <p>
                        Contact customer support as soon as possible if you need to update your
                        delivery information.
                    </p>
                ',
                'position' => 9,
            ],

            [
                'question' => 'What should I do if I receive a damaged product?',
                'answer' => '
                    <p>
                        If your product arrives damaged, please contact our customer support team
                        as soon as possible. Share your order number and clear photos or videos
                        showing the damaged product and packaging.
                    </p>

                    <p>
                        Our team will review the issue and guide you through the return,
                        replacement, or refund process where applicable.
                    </p>
                ',
                'position' => 10,
            ],

            [
                'question' => 'What should I do if I receive the wrong product?',
                'answer' => '
                    <p>
                        If you receive a product different from what you ordered, contact our
                        support team immediately. Please provide your order number and clear photos
                        of the received product.
                    </p>

                    <p>
                        After verification, we will guide you through the appropriate replacement
                        or return process.
                    </p>
                ',
                'position' => 11,
            ],

            [
                'question' => 'Can I return a product after receiving it?',
                'answer' => '
                    <p>
                        Eligible products can be returned according to our Return & Refund Policy.
                        Return eligibility depends on the product type, condition, reason for
                        return, and the applicable return period.
                    </p>
                ',
                'position' => 12,
            ],

            [
                'question' => 'How long do I have to request a return?',
                'answer' => '
                    <p>
                        Return requests should be submitted as soon as possible after receiving
                        the order. The applicable return period may vary depending on the product
                        category and the reason for the return.
                    </p>

                    <p>
                        Please review our Return & Refund Policy for the latest applicable conditions.
                    </p>
                ',
                'position' => 13,
            ],

            [
                'question' => 'When will I receive my refund?',
                'answer' => '
                    <p>
                        Refunds are processed after the returned product is received and inspected,
                        and the request is approved. The time required for the refund to reach you
                        depends on the payment method and the relevant financial institution.
                    </p>
                ',
                'position' => 14,
            ],

            [
                'question' => 'How can I know whether a product is available?',
                'answer' => '
                    <p>
                        Product availability is shown on the product page. If a product is marked
                        as out of stock, you may not be able to place an order for it until stock
                        becomes available again.
                    </p>
                ',
                'position' => 15,
            ],

            [
                'question' => 'Can I change the quantity or product variation after ordering?',
                'answer' => '
                    <p>
                        You may request a change before the order is processed or dispatched.
                        Changes are subject to product availability and order status.
                    </p>

                    <p>
                        Contact customer support as soon as possible if you need to change the
                        quantity, size, color, or other product variation.
                    </p>
                ',
                'position' => 16,
            ],

            [
                'question' => 'Are the product prices shown on the website final?',
                'answer' => '
                    <p>
                        The prices displayed on the website are the current listed prices and may
                        change from time to time. Promotional prices and discounts may also have
                        specific validity periods or conditions.
                    </p>
                ',
                'position' => 17,
            ],

            [
                'question' => 'Do you offer discounts or promotional campaigns?',
                'answer' => '
                    <p>
                        Yes. We regularly offer promotional campaigns, discounts, coupon codes,
                        flash sales, and special offers on selected products. Available offers
                        are displayed on the website and may be subject to specific terms.
                    </p>
                ',
                'position' => 18,
            ],

            [
                'question' => 'How can I use a coupon code?',
                'answer' => '
                    <p>
                        If a coupon is available for your order, enter the coupon code in the
                        coupon field during checkout and apply it before placing the order.
                    </p>

                    <p>
                        Coupon codes may have conditions such as minimum order value, eligible
                        products, customer eligibility, or expiration dates.
                    </p>
                ',
                'position' => 19,
            ],

            [
                'question' => 'What happens if I am unavailable when the courier arrives?',
                'answer' => '
                    <p>
                        The courier may attempt to contact you and arrange another delivery attempt.
                        Repeated failed delivery attempts may result in additional charges,
                        cancellation, or return of the package depending on the courier policy.
                    </p>
                ',
                'position' => 20,
            ],

            [
                'question' => 'How can I contact customer support?',
                'answer' => '
                    <p>
                        You can contact our customer support team using the phone number, email
                        address, or contact form provided on our Contact Us page.
                    </p>

                    <p>
                        For faster assistance with an existing order, please provide your order
                        number and the phone number used during checkout.
                    </p>
                ',
                'position' => 21,
            ],

            [
                'question' => 'How can I report an incorrect or suspicious order activity?',
                'answer' => '
                    <p>
                        If you notice an order that you did not place, suspicious activity, or
                        incorrect information associated with an order, contact our customer
                        support team immediately so we can review the issue.
                    </p>
                ',
                'position' => 22,
            ],

            [
                'question' => 'Do you deliver products all over Bangladesh?',
                'answer' => '
                    <p>
                        We offer delivery across many locations in Bangladesh through our available
                        courier partners. Delivery availability and charges may vary depending on
                        the destination and courier coverage.
                    </p>
                ',
                'position' => 23,
            ],

            [
                'question' => 'Why was my order cancelled?',
                'answer' => '
                    <p>
                        An order may be cancelled due to reasons such as product unavailability,
                        incorrect customer information, failed verification, duplicate orders,
                        payment issues, suspicious activity, or other circumstances affecting
                        successful order processing.
                    </p>

                    <p>
                        If your order was cancelled and you need clarification, please contact
                        customer support.
                    </p>
                ',
                'position' => 24,
            ],

            [
                'question' => 'Can I place another order after my previous order is delivered?',
                'answer' => '
                    <p>
                        Yes. You can place new orders at any time using the phone number and
                        delivery information required during checkout.
                    </p>
                ',
                'position' => 25,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                [
                    'question' => $faq['question'],
                ],
                [
                    'answer'   => trim($faq['answer']),
                    'position' => $faq['position'],
                    'status'   => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
