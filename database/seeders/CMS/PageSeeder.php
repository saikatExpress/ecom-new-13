<?php

namespace Database\Seeders\CMS;

use App\Models\CMS\Page;
use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [

            /*
            |--------------------------------------------------------------------------
            | About Us
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'About Us',
                'slug' => 'about-us',

                'content' => '
                    <section>
                        <h1>About Us</h1>

                        <p>
                            Welcome to our online shopping platform, your trusted destination
                            for quality products, competitive prices, and a convenient shopping
                            experience across Bangladesh.
                        </p>

                        <p>
                            We started with a simple goal: to make online shopping easier,
                            safer, and more reliable for everyone. From everyday essentials
                            to the latest gadgets, fashion, lifestyle products, and home
                            appliances, we bring carefully selected products together in one
                            place.
                        </p>

                        <h2>Our Mission</h2>

                        <p>
                            Our mission is to create a customer-first ecommerce experience
                            built around product quality, transparent pricing, reliable
                            delivery, and responsive support.
                        </p>

                        <h2>What We Value</h2>

                        <ul>
                            <li><strong>Customer First:</strong> Every decision starts with the customer experience.</li>
                            <li><strong>Quality:</strong> We work to maintain reliable product standards.</li>
                            <li><strong>Transparency:</strong> We believe pricing, policies, and communication should be clear.</li>
                            <li><strong>Reliability:</strong> We focus on dependable order processing and delivery.</li>
                            <li><strong>Continuous Improvement:</strong> We continuously improve our products, service, and technology.</li>
                        </ul>

                        <h2>Why Shop With Us?</h2>

                        <ul>
                            <li>Carefully selected products</li>
                            <li>Competitive prices and regular offers</li>
                            <li>Fast and reliable delivery options</li>
                            <li>Multiple payment methods</li>
                            <li>Customer-friendly return and refund policies</li>
                            <li>Dedicated customer support</li>
                        </ul>

                        <h2>Our Commitment</h2>

                        <p>
                            We are committed to building a long-term relationship with our
                            customers by delivering genuine value before, during, and after
                            every purchase.
                        </p>
                    </section>
                ',

                'meta_title' => 'About Us | Your Trusted Online Shopping Platform',

                'meta_description' => 'Learn more about our ecommerce platform, mission, values, customer commitment, and why thousands of shoppers choose us.',

                'meta_keywords' => 'about us, ecommerce bangladesh, online shopping bangladesh, trusted ecommerce, online store',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact Us
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Contact Us',
                'slug' => 'contact-us',

                'content' => '
                    <section>
                        <h1>Contact Us</h1>

                        <p>
                            We are here to help. Whether you have a question about a product,
                            order, payment, delivery, return, refund, or any other issue,
                            our support team is ready to assist you.
                        </p>

                        <h2>Customer Support</h2>

                        <p>
                            Our customer support team is available to help with order-related
                            questions, product information, payment issues, delivery updates,
                            and after-sales support.
                        </p>

                        <div>
                            <h3>Phone</h3>
                            <p>+880 1XXXXXXXXX</p>

                            <h3>Email</h3>
                            <p>support@example.com</p>

                            <h3>Business Hours</h3>
                            <p>Saturday - Thursday: 9:00 AM - 8:00 PM</p>
                            <p>Friday: Limited Support</p>
                        </div>

                        <h2>Order Support</h2>

                        <p>
                            When contacting us about an order, please provide your order
                            number and the phone number used to place the order. This helps
                            us verify your information and provide faster assistance.
                        </p>

                        <h2>Business & Partnership</h2>

                        <p>
                            For business partnerships, wholesale inquiries, brand collaboration,
                            or other commercial opportunities, please contact our business team.
                        </p>

                        <h2>Send Us a Message</h2>

                        <p>
                            You can also contact us through the contact form available on our
                            website. Our team will review your message and respond as soon as possible.
                        </p>
                    </section>
                ',

                'meta_title' => 'Contact Us | Customer Support & Assistance',

                'meta_description' => 'Contact our customer support team for product, order, payment, delivery, return, refund, and business inquiries.',

                'meta_keywords' => 'contact us, customer support, ecommerce support, online shopping support, bangladesh ecommerce',
            ],

            /*
            |--------------------------------------------------------------------------
            | Privacy Policy
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',

                'content' => '
                    <section>
                        <h1>Privacy Policy</h1>

                        <p>
                            Your privacy is important to us. This Privacy Policy explains how
                            we collect, use, store, and protect information when you use our
                            website, place an order, contact us, or interact with our services.
                        </p>

                        <h2>Information We Collect</h2>

                        <p>
                            Depending on how you use our website, we may collect information such as:
                        </p>

                        <ul>
                            <li>Name</li>
                            <li>Phone number</li>
                            <li>Email address</li>
                            <li>Delivery address</li>
                            <li>Order information</li>
                            <li>Payment-related information</li>
                            <li>IP address and device/browser information</li>
                            <li>Information you provide when contacting support</li>
                        </ul>

                        <h2>How We Use Your Information</h2>

                        <ul>
                            <li>To process and deliver your orders</li>
                            <li>To verify customer and order information</li>
                            <li>To provide customer support</li>
                            <li>To process payments and refunds</li>
                            <li>To prevent fraud, abuse, and unauthorized activity</li>
                            <li>To improve products, services, and website performance</li>
                            <li>To communicate important order and service updates</li>
                        </ul>

                        <h2>Information Sharing</h2>

                        <p>
                            We do not sell or rent your personal information. We may share
                            necessary information with trusted service providers such as
                            courier companies, payment providers, technology providers,
                            and service partners when required to complete an order or
                            provide our services.
                        </p>

                        <h2>Data Security</h2>

                        <p>
                            We take reasonable technical and organizational measures to protect
                            your information against unauthorized access, misuse, alteration,
                            disclosure, or destruction.
                        </p>

                        <h2>Cookies and Similar Technologies</h2>

                        <p>
                            Our website may use cookies, local storage, and similar technologies
                            to maintain functionality, improve user experience, remember preferences,
                            analyze usage, and support security and fraud prevention.
                        </p>

                        <h2>Data Retention</h2>

                        <p>
                            We retain information for as long as reasonably necessary to provide
                            services, maintain business records, comply with legal requirements,
                            resolve disputes, and prevent fraud or abuse.
                        </p>

                        <h2>Changes to This Policy</h2>

                        <p>
                            We may update this Privacy Policy from time to time. Any changes will
                            become effective when the updated version is published on this page.
                        </p>
                    </section>
                ',

                'meta_title' => 'Privacy Policy | How We Protect Your Information',

                'meta_description' => 'Read our privacy policy to understand how we collect, use, protect, and manage customer information.',

                'meta_keywords' => 'privacy policy, data privacy, ecommerce privacy, customer data protection, online shopping privacy',
            ],

            /*
            |--------------------------------------------------------------------------
            | Terms & Conditions
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Terms & Condition',
                'slug' => 'terms-condition',

                'content' => '
                    <section>
                        <h1>Terms & Conditions</h1>

                        <p>
                            By accessing or using our website and placing an order, you agree
                            to the terms and conditions described on this page. Please read
                            these terms carefully before using our services.
                        </p>

                        <h2>Use of Website</h2>

                        <p>
                            You agree to use this website only for lawful purposes and in a way
                            that does not interfere with the operation, security, or availability
                            of the website.
                        </p>

                        <h2>Product Information</h2>

                        <p>
                            We make reasonable efforts to ensure that product names, images,
                            descriptions, prices, availability, and specifications are accurate.
                            However, minor variations may occur, and product availability can
                            change without prior notice.
                        </p>

                        <h2>Pricing</h2>

                        <p>
                            Product prices may change at any time. Promotional prices, discounts,
                            and campaign offers may be subject to specific terms and availability.
                        </p>

                        <h2>Orders</h2>

                        <p>
                            An order submitted through our website is subject to confirmation
                            and availability. We reserve the right to cancel or refuse an order
                            in cases including incorrect pricing, product unavailability, suspicious
                            activity, duplicate orders, or violation of our policies.
                        </p>

                        <h2>Customer Information</h2>

                        <p>
                            Customers are responsible for providing accurate contact and delivery
                            information. Incorrect information may result in delivery delays,
                            failed delivery, additional delivery attempts, or cancellation.
                        </p>

                        <h2>Payment</h2>

                        <p>
                            Available payment methods are displayed during checkout. Certain
                            payment methods may be subject to additional verification or terms.
                        </p>

                        <h2>Order Cancellation</h2>

                        <p>
                            Orders may be cancelled according to our cancellation policy.
                            Cancellation requests received after dispatch may not always be accepted.
                        </p>

                        <h2>Returns & Refunds</h2>

                        <p>
                            Returns and refunds are governed by our Return & Refund Policy.
                            Customers should review the policy before requesting a return.
                        </p>

                        <h2>Limitation of Liability</h2>

                        <p>
                            To the extent permitted by applicable law, we are not responsible
                            for indirect losses resulting from website interruptions, third-party
                            service failures, inaccurate customer information, or circumstances
                            beyond our reasonable control.
                        </p>

                        <h2>Changes to These Terms</h2>

                        <p>
                            We may update these terms from time to time. Continued use of our
                            website after changes are published constitutes acceptance of the
                            updated terms.
                        </p>
                    </section>
                ',

                'meta_title' => 'Terms & Conditions | Online Shopping Policies',

                'meta_description' => 'Read the terms and conditions governing website usage, orders, payments, cancellations, returns, refunds, and customer responsibilities.',

                'meta_keywords' => 'terms and conditions, ecommerce terms, online shopping policy, order terms, customer terms',
            ],

            /*
            |--------------------------------------------------------------------------
            | Shipping & Delivery Policy
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Shipping & Refund Policy',
                'slug' => 'shipping-delivery-policy',

                'content' => '
                    <section>
                        <h1>Shipping & Delivery Policy</h1>

                        <p>
                            We aim to deliver every order safely and within the estimated
                            delivery time shown during checkout or communicated by our
                            customer support team.
                        </p>

                        <h2>Delivery Areas</h2>

                        <p>
                            We provide delivery services across Bangladesh, subject to
                            courier availability and service coverage.
                        </p>

                        <h2>Estimated Delivery Time</h2>

                        <ul>
                            <li><strong>Inside Dhaka:</strong> Usually 1-2 working days.</li>
                            <li><strong>Outside Dhaka:</strong> Usually 2-5 working days.</li>
                        </ul>

                        <p>
                            Delivery times are estimates and may be affected by weather,
                            public holidays, courier delays, traffic, strikes, address issues,
                            product availability, or other circumstances beyond our control.
                        </p>

                        <h2>Delivery Charges</h2>

                        <p>
                            Delivery charges depend on the delivery area, order conditions,
                            promotional campaigns, and the selected delivery option. The
                            applicable delivery fee will be shown before order confirmation.
                        </p>

                        <h2>Receiving Your Order</h2>

                        <p>
                            Please inspect the package when receiving your order. If you notice
                            visible damage or a major issue, inform the delivery person and
                            contact our support team as soon as possible.
                        </p>

                        <h2>Failed Delivery</h2>

                        <p>
                            Delivery may fail due to an incorrect address, unavailable recipient,
                            unreachable phone number, refusal to receive the package, or other
                            circumstances. Additional delivery attempts or charges may apply.
                        </p>

                        <h2>Courier Delays</h2>

                        <p>
                            Once an order is handed over to a third-party courier, delivery timing
                            may be influenced by the courier company. We will work with the courier
                            to resolve issues and provide available tracking information.
                        </p>
                    </section>
                ',

                'meta_title' => 'Shipping & Delivery Policy | Delivery Information',

                'meta_description' => 'Learn about delivery areas, estimated shipping time, delivery charges, failed delivery, courier delays, and order receiving guidelines.',

                'meta_keywords' => 'shipping policy, delivery policy, ecommerce delivery, dhaka delivery, bangladesh courier delivery',
            ],

            /*
            |--------------------------------------------------------------------------
            | Return & Refund Policy
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Return & Refund Policy',
                'slug' => 'return-refund-policy',

                'content' => '
                    <section>
                        <h1>Return & Refund Policy</h1>

                        <p>
                            We want you to have confidence in every purchase. If you receive
                            an eligible product with a valid issue, you may request a return,
                            replacement, or refund according to the conditions described below.
                        </p>

                        <h2>Eligible Return Reasons</h2>

                        <ul>
                            <li>Wrong product received</li>
                            <li>Damaged product received</li>
                            <li>Missing item or accessory</li>
                            <li>Product significantly different from the approved description</li>
                            <li>Manufacturing defect, where applicable</li>
                        </ul>

                        <h2>Return Request Period</h2>

                        <p>
                            Customers should contact our support team as soon as possible after
                            receiving the order. Certain product categories may have different
                            return periods or special conditions.
                        </p>

                        <h2>Return Conditions</h2>

                        <ul>
                            <li>The product should be unused where applicable.</li>
                            <li>Original packaging should be preserved where possible.</li>
                            <li>Accessories, manuals, tags, and included items should be returned.</li>
                            <li>Proof of purchase or order information may be required.</li>
                        </ul>

                        <h2>Non-Returnable Items</h2>

                        <p>
                            Certain products may not be eligible for return due to hygiene,
                            safety, customization, perishability, digital delivery, or other
                            product-specific conditions. Such restrictions will be communicated
                            where applicable.
                        </p>

                        <h2>Refund Process</h2>

                        <p>
                            Once a returned product is received and inspected, we will determine
                            whether the request qualifies for a refund or replacement.
                        </p>

                        <p>
                            Approved refunds may be processed through the original payment method
                            or another available method depending on the payment gateway and
                            transaction type.
                        </p>

                        <h2>Refund Timeline</h2>

                        <p>
                            Refund processing time depends on the selected payment method,
                            financial institution, and applicable verification procedures.
                        </p>

                        <h2>Return Delivery Cost</h2>

                        <p>
                            Return delivery charges may depend on the reason for the return.
                            If the issue is caused by our error, we may cover eligible return
                            delivery costs. Other return requests may be subject to customer-paid
                            return charges.
                        </p>

                        <h2>How to Request a Return or Refund</h2>

                        <p>
                            Contact our customer support team with your order number, phone number,
                            reason for the request, and relevant photos or videos when applicable.
                        </p>
                    </section>
                ',

                'meta_title' => 'Return & Refund Policy | Customer Returns & Refunds',

                'meta_description' => 'Learn about eligible returns, replacement conditions, refund processing, non-returnable items, and how to request a return or refund.',

                'meta_keywords' => 'return policy, refund policy, ecommerce return, product return bangladesh, online shopping refund',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                [
                    'slug' => $page['slug'],
                ],
                [
                    'name'             => $page['name'],
                    'content'          => trim($page['content']),
                    'meta_title'       => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                    'meta_keywords'    => $page['meta_keywords'],
                    'status'            => StatusEnum::ACTIVE->value,
                ]
            );
        }
    }
}
